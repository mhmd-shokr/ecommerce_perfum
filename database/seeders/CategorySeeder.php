<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::updateOrCreate(
            ['slug' => 'men-perfumes'],
            [
                'name' => [
                    'en' => 'Men Perfumes',
                    'ar' => 'عطور رجالي',
                ],
                'images' => 'https://media.istockphoto.com/id/502426696/photo/beautiful-seascape.jpg',
                'status' => 1,
            ]
        );

        Category::updateOrCreate(
            ['slug' => 'women-perfumes'],
            [
                'name' => [
                    'en' => 'Women Perfumes',
                    'ar' => 'عطور نسائي',
                ],
                'images' => 'https://media.istockphoto.com/id/502426696/photo/beautiful-seascape.jpg',
                'status' => 1,
            ]
        );

        Category::updateOrCreate(
            ['slug' => 'unisex'],
            [
                'name' => [
                    'en' => 'Unisex',
                    'ar' => 'للجنسين',
                ],
                'images' => 'https://media.istockphoto.com/id/502426696/photo/beautiful-seascape.jpg',
                'status' => 1,
            ]
        );
    }
}