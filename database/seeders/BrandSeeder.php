<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::create([
            'name' => [
                'en' => 'Dior',
                'ar' => 'ديور'
            ],
            'slug' => 'dior'
        ]);
    
        Brand::create([
            'name' => [
                'en' => 'Chanel',
                'ar' => 'شانيل'
            ],
            'slug' => 'chanel'
        ]);
    
        Brand::create([
            'name' => [
                'en' => 'Tom Ford',
                'ar' => 'توم فورد'
            ],
            'slug' => 'tom-ford'
        ]);
    }
}
