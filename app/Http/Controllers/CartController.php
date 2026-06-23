<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index() {
        return view('customer.cart');
    }
    
    public function addToCart(Product $product,Request $request){
        $cart=session('cart',[]);

        $qty=(int)$request->quantity;
        if(isset($cart[$product->id])){
            $cart[$product->id]['quantity'] += $qty;
        }else{
            $cart[$product->id]=[
                'name' => $product->getTranslation('name', app()->getLocale()),
                'quantity'=>$qty,
                'price'=>$product->price,
                'images'=>$product->images,
                'short_description'=>$product->getTranslation('short_description', app()->getLocale()),
            ];
        }
        session()->put('cart',$cart);
        return redirect()->back()->with("success",__('product added success to cart'));
    }

    public function update(Request $request,$productId){
        $cart = session('cart', []);
    if (isset($cart[$productId])) {
        $cart[$productId]['quantity'] = max(1, (int) $request->quantity);
        session()->put('cart', $cart);
    }
    return redirect()->back()->with('success', __('Cart updated'));
    }

    public function remove($productId) {
    $cart = session('cart', []);
    unset($cart[$productId]);
    session()->put('cart', $cart);
    return redirect()->back()->with('success', __('Item removed.'));
}

public function clear() {
    session()->forget('cart');
    return redirect()->route('cart.index')->with('success', __('Cart cleared.'));
}
}
