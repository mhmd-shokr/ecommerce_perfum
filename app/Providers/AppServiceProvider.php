<?php

namespace App\Providers;

use App\Interfaces\BrandInterFace;
use App\Interfaces\CategoryInterface;
use App\Repositries\BrandRepositry;
use App\Repositries\CategoryRepositry;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
