<?php

use App\Http\Controllers\Api\V1\Admin\CategoryController;
use App\Http\Controllers\Api\V1\Admin\BrandController;
use App\Http\Controllers\Api\V1\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\Customer\ProductController as CustomerProductController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




Route::prefix('v1')->group(function(){
    Route::post("/register",[AuthController::class,'register']);
    Route::post('/login',[AuthController::class,'login']);
    Route::post('/forgot-password',[AuthController::class,'forgotPassword'])
    ->middleware('throttle:3,1');
    Route::post('/verify-reset-otp',[AuthController::class, 'verifyResetOtp']
    )->middleware('throttle:5,1');
    Route::post(
        '/reset-password',
        [AuthController::class, 'resetPassword']
    )->middleware('throttle:5,1');

    Route::get('/products', [CustomerProductController::class,'index']);
    Route::get('/products/{slug}', [CustomerProductController::class, 'show']);

    Route::middleware('auth:sanctum')->group(function(){
        // Auth
        Route::get('/user',[AuthController::class,'user']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/logout-all', [AuthController::class, 'logoutAll']);
        Route::post('/verify-email',[AuthController::class,'verifyEmail']);
        Route::post('/resend-otp',[AuthController::class,'resendOtp'])->middleware('throttle:3,1');
        //update-profile
        Route::put('/update-profile',[UserController::class,'update']);
        //change-password
        Route::put('/change-password',[UserController::class, 'changePassword']);
        //delete-account
        Route::delete('/delete-account',[UserController::class, 'deleteAccount']);
        //devices
        Route::get('/devices',[UserController::class,'getDevices']);
    
        //customer
        //Admin
        Route::prefix('admin')->middleware('role:admin')->group(function(){
            //products for admin
            Route::apiResource('products', AdminProductController::class);
            //categories
            Route::get('/categories', [CategoryController::class, 'index']);
            Route::post('/categories', [CategoryController::class, 'store']);
            Route::get('/categories/{id}', [CategoryController::class, 'show']);
            Route::put('/categories/{id}', [CategoryController::class, 'update']);
            Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
            //brands
            Route::get('/brands', [BrandController::class, 'index']);
            Route::post('/brands', [BrandController::class, 'store']);
            Route::get('/brands/{id}', [BrandController::class, 'show']);
            Route::put('/brands/{id}', [BrandController::class, 'update']);
            Route::delete('/brands/{id}', [BrandController::class, 'destroy']);     

        });

    });
});
