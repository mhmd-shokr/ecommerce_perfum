<?php
namespace App\Helpers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class CacheHelper{
    public static function clearDashboardCache()
        {
            Cache::forget('dashboard.stats');
        }
    public static function clearProductCaches(Product $product){
        Cache::forget('dashboard.stats');
        Cache::forget("product.{$product->slug}");
        Cache::forget("product.related.{$product->id}");
        Cache::forget('home.categories');
        Cache::forget('home.brands');
        Cache::forget("admin.product.{$product->id}");
        Cache::forget("customer.product.{$product->slug}");
    }

    public static function clearCategoryCaches(Category $category): void
        {
            Cache::forget('home.categories');
            Cache::forget("category.{$category->slug}");
            Cache::forget('dashboard.stats');
        }

        public static function clearBrandCaches(Brand $brand): void
        {
            Cache::forget('home.brands');
        }
}