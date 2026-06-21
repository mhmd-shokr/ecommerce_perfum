<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\customer\ReviewController;
use App\Http\Controllers\Customer\StoreController;
use App\Http\Controllers\Customer\WishlistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
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
Route::get('wishlist',[WishlistController::class,'index'])->name('wishlist.index');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.')->group(function(){
    Route::get("/dashboard",function(){
        return view('admin.dashboard');
    })->name('dashboard');
    //Category
    Route::resource('categories',CategoryController::class)->except('show');

    //Brands
    Route::resource('brands',BrandController::class);
    //products
    Route::resource('products',ProductController::class);
});

//localization
Route::get("/lang/{locale}",function($locale){

        session(['locale'=>$locale]);
        return back();
});
require __DIR__.'/auth.php';

