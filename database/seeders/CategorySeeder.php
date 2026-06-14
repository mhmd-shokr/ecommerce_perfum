<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => [
                'en' => 'Men Perfumes',
                'ar' => 'عطور رجالي'
            ],
            'slug' => 'men-perfumes'
        ]);
    
        Category::create([
            'name' => [
                'en' => 'Women Perfumes',
                'ar' => 'عطور نسائي'
            ],
            'slug' => 'women-perfumes'
        ]);
    
        Category::create([
            'name' => [
                'en' => 'Unisex',
                'ar' => 'للجنسين'
            ],
            'slug' => 'unisex'
        ]);
    }
}
