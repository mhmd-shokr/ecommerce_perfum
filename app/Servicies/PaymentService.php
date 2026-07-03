<?php
namespace App\Servicies;

use App\Models\Order;

use App\Repositries\CheckoutRepository;
use App\Servicies\StockService;
use App\Servicies\StripeService;
use Illuminate\Support\Facades\DB;
use Stripe\PaymentIntent;

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
            $order->update([
                'status'=>'processing',
                'payment_status'=>'pending',
            ]);
            $this->decrementAndClear($order);
        });
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

    public function confirmStripe(Order $order , PaymentIntent  $paymentIntent){
        DB::transaction(function() use($order,$paymentIntent){
            // $paymentIntent=$this->stripeService->getPaymentIntent($paymentIntentId);

            if($order->payment_reference !== $paymentIntent->id){
                throw new \Exception(__('Invalid payment reference.'));
            }

            if(!$this->stripeService->isPaymentSucceeded($paymentIntent)){
                $order->update(['payment_status' => 'failed']);
                throw new \Exception(__('Payment failed. Please try again.'));
            }

            $order->update([
                'status'=>'processing',
                'payment_status'=>'paid',
            ]);

            $this->decrementAndClear($order);

        });
    }
}