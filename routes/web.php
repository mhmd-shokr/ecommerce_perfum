<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\customer\ReviewController;
use App\Http\Controllers\Customer\StoreController;
use App\Http\Controllers\Customer\VerificationController;
use App\Http\Controllers\Customer\WishlistController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/',[StoreController::class,'home'])->name('home');

Route::get('/products/{slug}',[StoreController::class,'show'])->name('store.products.show');
Route::get('/shop',[ShopController::class,'shop'])->name('shop.products');
Route::post('/product/{product}/review', [ReviewController::class, 'store'])->name('store.review')
    ->middleware('auth');
//Wishlist
Route::post('/wishlist/toggle/{product}',[WishlistController::class,'toggle'])->name('wishlist.toggle');
Route::get('/wishlist',[WishlistController::class,'index'])->name('wishlist.index');
//Cart
Route::post('/add-to-cart/{product}',[CartController::class,'addToCart'])->name('add.to.cart');
Route::get("/cart",[CartController::class,'index'])->name('cart.index');
Route::patch('/cart/update/{productId}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear',          [CartController::class, 'clear'])->name('cart.clear');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //customer orders
    Route::get('my-orders',[CustomerOrderController::class,'index'])->name('my.orders.index');
    Route::get('my-order/{order}',[CustomerOrderController::class,'show'])->name('my.order.show');
    //checkout
    Route::get('checkout', [CheckoutController::class, 'index'])
        ->name('checkout.index');
    Route::post('checkout', [CheckoutController::class, 'store'])
        ->name('checkout.store');
    Route::get('checkout/confirmed/{order}', [CheckoutController::class, 'confirmed'])
        ->name('checkout.confirmed');
    Route::post('checkout/shipping-cost', [CheckoutController::class, 'shippingCost'])
        ->name('checkout.shipping.cost');
        Route::post('/checkout/apply-coupon', [CouponController::class, 'applyCoupon'])
        ->name('checkout.coupon.apply');
    //payment
    Route::prefix('payment')->name('payment.')->group(function(){
        // Route::get('{order}',[PaymentController::class,'index'])->name('index');
        Route::get('{order}/cash',[PaymentController::class,'cash'])->name('cash');
        Route::get('{order}/stripe',[PaymentController::class,'stripe'])->name('stripe');
        Route::get('{order}/stripe-confirm',[PaymentController::class,'stripeConfirm'])->name('stripe.confirm');
        Route::get('{order}/failed',[PaymentController::class,'failed'])->name('failed');
    });
});
 //webhook
Route::post('webhook/stripe',[WebhookController::class,'handle'])->name('webhook.stripe');

Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.')->group(function(){
    Route::get("/dashboard",[DashboardController::class,'index'])->name('dashboard');
    //Category
    Route::resource('categories',CategoryController::class)->except('show');
    //Brands
    Route::resource('brands',BrandController::class);
    //products
    Route::resource('products',ProductController::class);
    //order
    Route::get('orders',[AdminOrderController::class,'index'])->name('orders.index');
    Route::get('order/{order}',[AdminOrderController::class,'show'])->name('order.show');
    Route::patch('order/{order}',[AdminOrderController::class,'update'])->name('order.update');
    //coupon 
    Route::resource('coupons', CouponController::class)->except('show');
    //offers
    Route::resource('offers',OfferController::class)->except('edit','update');
    Route::post("offers/{offer}/send",[OfferController::class,'send'])->name('offers.send');

});

//localization
Route::get("/lang/{locale}",function($locale){

        session(['locale'=>$locale]);
        return back();
});
require __DIR__.'/auth.php';

