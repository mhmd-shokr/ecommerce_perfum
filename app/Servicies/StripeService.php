<?php
namespace App\Servicies;

use App\Models\Order;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Stripe\StripeClient;

class StripeService{
    private StripeClient $stripe;
    public function __construct(){
        $this->stripe=new StripeClient(config('services.stripe.secret_key'));
    }

    public function createPaymentIntent(Order $order){
        return $this->stripe->paymentIntents->create([
            'amount'=>(int)($order->total * 100),
            'currency'=>'usd',
            'metadata'=>[
                'order_id'=>$order->id,
                'order_number'=>$order->order_number,
                'user_id'=>$order->user_id,
            ],
        ]);
    }

    public function getPaymentIntent(string $paymentIntentId){
        return $this->stripe->paymentIntents->retrieve($paymentIntentId);
    }

    public function isPaymentSucceeded(PaymentIntent $paymentIntent){
        return $paymentIntent->status ==='succeeded';
    }

    public function getPublishableKey(): string
    {
        return config('services.stripe.key');
    }
}