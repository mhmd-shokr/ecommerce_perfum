<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/home', function () {
    return view('customer.home');
})->name('home');

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
