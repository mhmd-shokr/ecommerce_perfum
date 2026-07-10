<?php

namespace App\Providers;

use App\Events\OrderPlaced;
use App\Interfaces\AddressInterface;
use App\Interfaces\BrandInterFace;
use App\Interfaces\CartInterface;
use App\Interfaces\CategoryInterface;
use App\Interfaces\CheckoutInterface;
use App\Interfaces\CouponInterface;
use App\Interfaces\OrderInterface;
use App\Interfaces\ProductInterface;
use App\Interfaces\ShippingZoneInterface;
use App\Interfaces\UserInterface;
use App\Listeners\NotifyAdminNewOrderListener;
use App\Listeners\SendOrderConfirmationListener;
use App\Models\Address;
use App\Models\Coupon;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Review;
use App\Models\ShippingZone;
use App\Policies\AddressPolicy;
use App\Policies\CouponPolicy;
use App\Policies\OfferPolicy;
use App\Policies\OrderPolicy;
use App\Policies\ReviewPolicy;
use App\Repositries\AddressRepository;
use App\Repositries\BrandRepositry;
use App\Repositries\CartRepository;
use App\Repositries\CategoryRepositry;
use App\Repositries\CheckoutRepository;
use App\Repositries\CouponRepository;
use App\Repositries\OrderRepository;
use App\Repositries\ProductRepository;
use App\Repositries\ShippingZoneRepository;
use App\Repositries\UserRepository;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryInterface::class,CategoryRepositry::class);
        $this->app->bind(BrandInterFace::class,BrandRepositry::class);
        $this->app->bind(ProductInterface::class,ProductRepository::class);
        $this->app->bind(CheckoutInterface::class,CheckoutRepository::class);
        $this->app->bind(AddressInterface::class,AddressRepository::class);
        $this->app->bind(ShippingZoneInterface::class,ShippingZoneRepository::class);
        $this->app->bind(OrderInterface::class,OrderRepository::class);
        $this->app->bind(CouponInterface::class,CouponRepository::class);
        $this->app->bind(UserInterface::class,UserRepository::class);
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Review::class,ReviewPolicy::class);
        Gate::policy(Order::class,OrderPolicy::class);
        Gate::policy(Coupon::class,  CouponPolicy::class); 
        Gate::policy(Offer::class,   OfferPolicy::class);



        Paginator::useBootstrapFive();
    }
}
