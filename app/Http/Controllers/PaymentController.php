<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Servicies\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PaymentController extends Controller
{
    public function __construct(protected PaymentService $paymentService){}
    public function cash(Order $order){
        Gate::authorize('view',$order);


        if ($order->payment_status !== 'pending') {
            return redirect()->route('checkout.confirmed', $order->id);
        }

    
            $this->paymentService->handelCash($order);

            return redirect()
                ->route('checkout.confirmed', $order->id)
                ->with('success', __('Order placed successfully'));

    }

    public function stripe(Order $order)
{
    Gate::authorize('view', $order);

    if ($order->payment_status !== 'pending') {
        return redirect()->route('checkout.confirmed', $order->id);
    }
    try {
        $clientSecret = $this->paymentService->initiateStripe($order);
        return view('customer.payment.stripe', [
            'order' => $order,
            'clientSecret' => $clientSecret,
            'stripeKey' => config('services.stripe.publishable_key'),
        ]);
    } catch (\Exception $e) {
        return back()->with('error', $e->getMessage());
    }
}

public function stripeConfirm(Request $request, Order $order)
{
    Gate::authorize('view', $order);

    if (!$request->payment_intent) {
        return redirect()
            ->route('payment.failed', $order->id)
            ->with('error', __('Invalid payment request.'));
    }

    try {

        $this->paymentService->confirmStripe(
            $order,
            $request->payment_intent
        );

        return redirect()
            ->route('checkout.confirmed', $order->id)
            ->with('success', __('Payment successful! Your order is confirmed.'));

    } catch (\Exception $e) {

        return redirect()
            ->route('payment.failed', $order->id)
            ->with('error', $e->getMessage());

    }
}
    public function failed(Order $order)
    {
        Gate::authorize('view',$order);


        return view('customer.payment.failed', compact('order'));
    }
}
