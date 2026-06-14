<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nameEn = $this->faker->unique()->words(2, true);
        return [
            'category_id' => 1,
            'brand_id' => 1,

            // Spatie Translatable JSON
            'name' => [
                'en' => $nameEn,
                'ar' => 'منتج ' . $nameEn,
            ],

            'slug' => Str::slug($nameEn),

            'description' => [
                'en' => $this->faker->paragraph(),
                'ar' => 'وصف عربي للمنتج',
            ],

            'short_description' => [
                'en' => $this->faker->sentence(),
                'ar' => 'وصف مختصر بالعربي',
            ],

            'price' => $this->faker->numberBetween(100, 2000),
            'sale_price' => $this->faker->optional()->numberBetween(80, 1500),

            'sku' => strtoupper(Str::random(10)),

            'stock' => $this->faker->numberBetween(0, 100),

            'gender' => $this->faker->randomElement(['Men', 'Women', 'Unisex', 'Kids']),

            'is_featured' => $this->faker->boolean(),
            'is_bestseller' => $this->faker->boolean(),
            'status' => true,
        ];
    }
}
