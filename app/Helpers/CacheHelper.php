<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class CacheHelper{
    public static function clearDashboardCache(){
        Cache::forget('dashboard.stats');
    }
}