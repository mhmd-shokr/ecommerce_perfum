<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Servicies\PaymentService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function __construct(protected PaymentService $paymentService)
    {}

    // public function index(Order $order){
    //     if($order->user_id !==Auth::id()){
    //         abort(403);
    //     }

    //     if($order->payment_status !== 'pending' ){
    //         return redirect()->route('checkout.confirmed', $order->id)
    //             ->with('info', __('This order has already been paid.'));
    //     }

    //     return view('customer.payment.index', compact('order'));
    // }

    public function cash(Order $order){
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->payment_status !== 'pending') {
            return redirect()->route('checkout.confirmed', $order->id);
        }

        try {
            $this->paymentService->handelCash($order);

            return redirect()
                ->route('checkout.confirmed', $order->id)
                ->with('success', __('Order placed successfully'));

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function stripe(Order $order){
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->payment_status !== 'pending') {
            return redirect()->route('checkout.confirmed', $order->id);
        }

        try {
            $clientSecret =$this->paymentService->initiateStripe($order);

            return view('customer.payment.stripe', [
                'order'        => $order,
                'clientSecret' => $clientSecret,
                'stripeKey'    => config('services.stripe.publishable_key'),
            ]);
        }catch (\Exception $e) {
            return redirect()
                ->route('payment.index', $order->id)
                ->with('error', $e->getMessage());
        }
    }

    public function stripeConfirm(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if (!$request->payment_intent) {
            return redirect()
                ->route('payment.failed', $order->id)
                ->with('error', __('Invalid payment request.'));
        }

        try{
            $this->paymentService->confirmStripe($order,$request->payment_intent);
            return redirect()
                ->route('checkout.confirmed', $order->id)
                ->with('success', __('Payment successful! Your order is confirmed.'));
        }catch(\Exception $e){
            return redirect()
            ->route('payment.failed', $order->id)
            ->with('error', $e->getMessage());
        }
    }
    
    public function failed(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('customer.payment.failed', compact('order'));
    }
}
