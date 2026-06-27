<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Servicies\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

class WebhookController extends Controller
{
    public function __construct(protected PaymentService $paymentService){}


    public function onSucceeded(object $paymentIntent){
        $order=Order::where('payment_reference',$paymentIntent->id)->first();
        if(!$order)return;
        //if completed by Browser
        if ($order->payment_status === 'paid') return;
        $this->paymentService->confirmStripe($order,$paymentIntent->id);
    }

    public function onFailed(object $paymentIntent){
        $order=Order::where('payment_reference',$paymentIntent->id)->first();
        if(!$order)return;
        //if completed by Browser
        $order->update(['payment_status' => 'failed']);
    }

    public function handle(Request $request){
        $payload=$request->getContent();
        $sigHeader=$request->header('Stripe-Signature');
        $secret=config('services.stripe.webhook_secret');

        try{
            $event=Webhook::constructEvent($payload,$sigHeader,$secret);
        }catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        }
        catch(SignatureVerificationException $e){
            return response()->json(['error'=>'Invalid signature'],404);
        }

        match($event->type){
            'payment_intent.succeeded'
                => $this->onSucceeded($event->data->object),
            'payment_intent.payment_failed'
                => $this->onFailed($event->data->object),
            default => null,
        };
        Log::info('Stripe webhook hit', $event->toArray());
        return response()->json(['status' => 'ok']);
    }
}
