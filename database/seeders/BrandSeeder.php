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
        Brand::firstOrCreate(
            ['slug'=>'Dior'],
            [
            'name' => [
                'en' => 'Dior',
                'ar' => 'ديور'
            ],
            'slug' => 'dior',
            'logo'=>'https://chatgpt.com/c/6a2d4c4c-15c0-83ea-a881-24fed212d1da'
        ]);
    
        Brand::firstOrCreate( 
            ['slug'=>'chanel'],
            
            [
            'name' => [
                'en' => 'Chanel',
                'ar' => 'شانيل'
            ],
            'slug' => 'chanel',
            'logo'=>'https://chatgpt.com/c/6a2d4c4c-15c0-83ea-a881-24fed212d1da'
        ]);
    
        Brand::firstOrCreate(
            ['slug'=>'tom-ford'],
            
            [
            'name' => [
                'en' => 'Tom Ford',
                'ar' => 'توم فورد'
            ],
            'slug' => 'tom-ford',
            'logo'=>'https://chatgpt.com/c/6a2d4c4c-15c0-83ea-a881-24fed212d1da'
        ]);
    }
}
