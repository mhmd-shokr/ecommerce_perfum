<?php

namespace App\Providers;

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
use App\Models\ShippingZone;
use App\Repositries\BrandRepositry;
use App\Repositries\CartRepository;
use App\Repositries\CategoryRepositry;
use App\Repositries\CheckoutRepository;
use App\Repositries\ProductRepository;
use App\Repositries\ShippingZoneRepository;
use App\Repositries\AddressRepository;
use App\Repositries\CouponRepository;
use App\Repositries\OrderRepository;
use App\Repositries\UserRepository;
use Illuminate\Pagination\Paginator;
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
        Paginator::useBootstrapFive();
    }
}
