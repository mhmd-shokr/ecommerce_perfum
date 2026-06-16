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
            'slug' => 'men-perfumes',
            'images'=>'https://media.istockphoto.com/id/502426696/photo/beautiful-seascape.jpg?s=1024x1024&w=is&k=20&c=43oqQvpdAyG6OBqP4qeCJSKbm8rRymF2LnJ9iu_Rj-0=0',
            'status'=>1,
        ]);
    
        Category::create([
            'name' => [
                'en' => 'Women Perfumes',
                'ar' => 'عطور نسائي'
            ],
            'slug' => 'women-perfumes',
            'images'=>'https://media.istockphoto.com/id/502426696/photo/beautiful-seascape.jpg?s=1024x1024&w=is&k=20&c=43oqQvpdAyG6OBqP4qeCJSKbm8rRymF2LnJ9iu_Rj-0=0',
            'status'=>1,
        ]);
    
        Category::create([
            'name' => [
                'en' => 'Unisex',
                'ar' => 'للجنسين'
            ],
            'slug' => 'unisex',
            'images'=>'https://media.istockphoto.com/id/502426696/photo/beautiful-seascape.jpg?s=1024x1024&w=is&k=20&c=43oqQvpdAyG6OBqP4qeCJSKbm8rRymF2LnJ9iu_Rj-0=0',
            'status'=>1,

        ]);
    }
}
