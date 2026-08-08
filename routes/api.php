<?php

use App\Http\Controllers\Api\V1\Admin\BrandController;
use App\Http\Controllers\Api\V1\Admin\CategoryController;
use App\Http\Controllers\Api\V1\Admin\DashboardController;
use App\Http\Controllers\Api\V1\Admin\OrderController as AdminOrderController ;
use App\Http\Controllers\Api\V1\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Api\V1\Admin\ReviewController as AdminReviewController ;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\Customer\AddressController;
use App\Http\Controllers\Api\V1\Customer\OrderController as CustomerOrderController ;
use App\Http\Controllers\Api\V1\Customer\ProductController as CustomerProductController;
use App\Http\Controllers\Api\V1\Customer\ReviewController as CustomerReviewController ;
use App\Http\Controllers\Api\V1\Customer\WishlistController;
use App\Http\Controllers\Api\V1\NotificationController;
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
    Route::get('/products/{product}/reviews',[CustomerReviewController::class, 'index']
    );
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

        //order
        Route::prefix('orders')->group(function(){
            Route::get('/', [CustomerOrderController::class, 'index']);
            Route::get('/{id}', [CustomerOrderController::class, 'show']);
        });
        //Review
        Route::post('/products/{product}/reviews',[CustomerReviewController::class, 'store']
        );
        Route::delete('/reviews/{review}',[CustomerReviewController::class, 'destroy']
        );
        //Wishlist
        Route::prefix('wishlist')->group(function () {
            Route::get('/', [WishlistController::class, 'index']);
            Route::post('/{product}', [WishlistController::class, 'store']);
            Route::delete('/{product}', [WishlistController::class, 'destroy']);
            Route::get('/check/{product}',[WishlistController::class, 'check']);
            Route::get('/count',[WishlistController::class, 'count']);
        });
        //Notifications
        Route::prefix('notifications')->group(function () {
            Route::get('/', [NotificationController::class, 'index']);
            Route::get('/unread', [NotificationController::class, 'unread']);
            Route::patch('/{notification}/read',[NotificationController::class, 'markAsRead']);
            Route::patch('/read-all',[NotificationController::class, 'markAllAsRead']);
            Route::delete('/{notification}',[NotificationController::class, 'destroy']);
        });
        //Address
        Route::apiResource('addresses', AddressController::class);

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
            //admin dashboard
            Route::get('/dashboard', [DashboardController::class, 'index'])
                    ->middleware('permission:view dashboard');
            //order
            Route::prefix('orders')->group(function(){
                Route::get('/', [AdminOrderController::class, 'index']);
                Route::get('/{order}', [AdminOrderController::class, 'show']);
                Route::put('/{order}/status',[AdminOrderController::class, 'updateStatus']
                );
            });
            //reviews
            Route::get('/reviews',[AdminReviewController::class, 'index']
            );
            //approve review
            Route::patch(
                'reviews/{review}/approve',
                [AdminReviewController::class, 'approve']
            );
            //reject review
            Route::patch(
                'reviews/{review}/reject',
                [AdminReviewController::class, 'reject']
            );
            //delete review
            Route::delete(
                'reviews/{review}',
                [AdminReviewController::class, 'destroy']
            );
        });

    });
});
