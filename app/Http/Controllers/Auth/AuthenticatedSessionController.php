<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
       
        $wishlist = session()->get('wishlist', []);
        $cart = session()->get('cart', []);
        $request->authenticate();

        $request->session()->regenerate();
        $user=auth()->user();
        if (! $user->is_active) {
            return back()->withErrors([
                'email' => __('Your account has been suspended. Please contact support.'),
            ]);
        }
        if($user->hasRole('admin')){
            session()->forget(['wishlist', 'cart']);
            return redirect()->route('admin.dashboard');
        } 

        foreach($wishlist as $productId){
            $user->Wishlists()->firstOrCreate([
                'product_id'=>$productId,
            ]);
        }

        foreach($cart as $productId=>$item){
            $product=Product::find($productId);
            if (!$product) continue;
            $qty=max(1,(int)$item['quantity']);
            $cartItem=$user->carts()->where('product_id',$productId)
            ->first();
            if($cartItem){
                $merged=min($cartItem->quantity+$qty,$product->stock_quantity);
                $cartItem->update(['quantity'=>$merged]);
            }else{
                $user->carts()->create([
                    'product_id' => $productId,
                    'quantity' => min($qty,$product->stock_quantity),
                ]);
            }
        }
        session()->forget(['wishlist', 'cart']);

        return redirect()->route('home');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
