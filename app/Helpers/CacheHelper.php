<?php
namespace App\Helpers;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class CacheHelper{
    public static function clearProductCaches(Product $product){
        Cache::forget('dashboard.stats');
        Cache::forget("product.{$product->slug}");
        Cache::forget("product.related.{$product->id}");
        Cache::forget('home.categories');
        Cache::forget('home.brands');
    }
}