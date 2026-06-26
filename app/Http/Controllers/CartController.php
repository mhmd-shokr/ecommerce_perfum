<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function index() {
        if(Auth::check()){
            $rowCarts=Auth::user()->carts()->with('product')->get();
            $cart=[];
            foreach($rowCarts as $item){
                $cart[$item->product_id] = [
                    'name'              => $item->product->getTranslation('name', app()->getLocale()),
                    'quantity'          => $item->quantity,
                    'price'             => $item->product->sale_price ?? $item->product->price,
                    'images'            => $item->product->images,
                    'short_description' => $item->product->getTranslation('short_description', app()->getLocale()),
                ];
            }
        }else{
            $cart=session('cart',[]);
        }
        return view('customer.cart',compact('cart'));
    }
    
    public function addToCart(Product $product,Request $request){

        if(Auth::check()){
                $cart=Cart::where('user_id',Auth::id())->where('product_id',$product->id)->first();
                $qty = max(1, (int)$request->input('quantity', 1));
                if($cart){
                    if(($cart->quantity+$qty) <= $product->stock_quantity){
                    $cart->increment('quantity',$qty);
                    }else{
                        return back()->with(
                            'error',
                            __('Not enough stock available')
                        );
                    }
                }else{
                    $cart=Cart::create([
                        'user_id'=>Auth::id(),
                        'product_id'=>$product->id,
                        'quantity'=>min($qty,$product->stock_quantity),
                    ]);
                }
            
        }else{
            $cart=session('cart',[]);
            $qty = max(1, (int)$request->input('quantity', 1));
            if(isset($cart[$product->id])){
                $newQty=$cart[$product->id]['quantity'] + $qty;
                $cart[$product->id]['quantity']=min($newQty,$product->stock_quantity);
            }else{
                $cart[$product->id]=[
                    'name' => $product->getTranslation('name', app()->getLocale()),
                    'quantity'=>min($qty, $product->stock_quantity),
                    'price'=>$product->sale_price ?? $product->price,
                    'images'=>$product->images,
                    'short_description'=>$product->getTranslation('short_description', app()->getLocale()),
                ];
            }
        session()->put('cart',$cart);
        }
        return redirect()->back()->with("success",__('product added success to cart'));
    }

    public function update(Request $request,$productId){
    if(Auth::check()){
        $cart = Cart::where('user_id', Auth::id())
        ->where('product_id', $productId)
        ->first();
    
    if ($cart) {
        $cart->update([
            'quantity' => min(
                max(1, (int)$request->quantity),
                $cart->product->stock_quantity
            )
        ]);
    }
    }else{

        $cart = session('cart', []);
    if (isset($cart[$productId])) {
        $product = Product::findOrFail($productId);
        $cart[$productId]['quantity'] = min(
            max(1, (int)$request->quantity),
            $product->stock_quantity
        );
        session()->put('cart', $cart);
    }
    }

    return redirect()->back()->with('success', __('Cart updated'));
    }

    public function remove($productId) {
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->delete();
        } else {
            $cart = session('cart', []);
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', __('Item removed.'));
    }

    public function clear() {
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())->delete();
        } else {
            session()->forget('cart');
        }
        return redirect()->back()->with('success', __('Cart cleared.'));
    }
}
