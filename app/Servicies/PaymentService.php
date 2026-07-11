<?php
namespace App\Servicies;

use App\Events\OrderPlaced;
use App\Helpers\CacheHelper;
use App\Jobs\NotifyAdminNewOrder;
use App\Jobs\SendOrderConfirmationEmail;

use App\Models\Order;
use App\Repositries\CheckoutRepository;
use App\Servicies\StockService;
use App\Servicies\StripeService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PaymentService{
    public function __construct(
        protected StockService $stock_service,
        protected CheckoutRepository $CheckRepo,
        protected StripeService $stripeService,
    ){}

    public function decrementAndClear(Order $order){
        $order->loadMissing('items.product');
        foreach($order->items as $item){
            if($item->product){
                $this->stock_service->decrease(
                    $item->product,
                    $item->quantity,
                    'order #'.$order->order_number
                );
            }
        }
        $this->CheckRepo->clearCart($order->user_id);
    }

    //when cash on delivery
    public function handelCash(Order $order){
        DB::transaction(function() use($order){
            $locked = Order::whereKey($order->id)->lockForUpdate()->firstOrFail();
            if(in_array($locked->status, ['processing', 'completed'])){
                return; 
            }
            $locked->update([
                'status'=>'processing',
                'payment_status'=>'pending',
            ]);
            $this->decrementAndClear($locked);
    CacheHelper::clearDashboardCache();
        });

        //Notify admin and customer
        event(new OrderPlaced($order));

    }

    public function initiateStripe(Order $order){
        //create paymentIntent
        $paymentIntent =$this->stripeService->createPaymentIntent($order);
        

        //store payment reference
        $order->update([
            'payment_reference'=>$paymentIntent->id,
        ]);

        //return client secret
        return $paymentIntent->client_secret;
    }

    public function confirmStripe(Order $order , string $paymentIntentId){
        $paymentIntent=$this->stripeService->getPaymentIntent($paymentIntentId);
        $succeeded = $this->stripeService->isPaymentSucceeded($paymentIntent);
        $failureException = null;
        DB::transaction(function() use($order,$paymentIntentId,$succeeded,&$failureException){
            $locked = Order::whereKey($order->id)
            ->lockForUpdate()
            ->firstOrFail();
            if ($locked->payment_status === 'paid') {
                return;
            }

            
            
            if($locked->payment_reference !== $paymentIntentId){
                throw new \Exception(__('Invalid payment reference.'));
            }

            
            if(!$succeeded){
                $locked->update(['payment_status' => 'failed']);
                $failureException = new \Exception(__('Payment failed. Please try again.'));
                return;
            }
            $locked->update([
                'status'=>'processing',
                'payment_status'=>'paid',
            ]);

            $this->decrementAndClear($locked);
    CacheHelper::clearDashboardCache();        });
        //Notify admin and customer
        if(!$failureException){
            event(new OrderPlaced($order));
        }
        
        if($failureException){
            throw $failureException;
        }
    }
}