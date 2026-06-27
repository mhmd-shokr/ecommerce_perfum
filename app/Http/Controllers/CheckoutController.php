<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Servicies\CheckoutService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function __construct(protected CheckoutService $checkout){}

    public function index(){
        try{
            $data=$this->checkout->getCheckoutData(Auth::id());
            return view('customer.checkout', $data);
        }catch(\Exception $e){
            return redirect()->route('cart.index')
                ->with('error', $e->getMessage());
        }
    }

    public function store(CheckoutRequest $request){
        try{
            $validated=$request->validated();
            $order=$this->checkout->placeOrder(Auth::id(),$validated);

            if($validated['payment_method']==='cash'){
                return redirect()
                ->route('payment.cash', $order->id);
            }
            return redirect()
            ->route('payment.stripe', $order->id);
            
        }catch(\Exception $e){
                return back()
                    ->withInput()
                    ->with('error', $e->getMessage());
            }
        }
        public function confirmed(Order $order){
            if($order->user_id !==Auth::id()){
                abort(404);
            }
            $order->load(['items.product','address']);
            return view('customer.order-confirmed', compact('order'));
        }

        public function shippingCost(Request $request)
    {
        $request->validate([
            'governorate' => 'required|string',
        ]);

        $cost = $this->checkout->getShippingCost($request->governorate);

        return response()->json(['cost' => $cost]);
    }
}

