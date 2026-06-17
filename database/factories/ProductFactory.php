<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
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
        $stock = $this->faker->numberBetween(0, 100);
        $price=$this->faker->numberBetween(100, 2000);
        return [
            'category_id' => Category::inRandomOrder()->value('id') ?? 1,
            'brand_id' => Brand::inRandomOrder()->value('id') ?? 1,

            // Spatie Translatable JSON
            'name' => [
                'en' => $nameEn,
                'ar' => 'منتج ' . $nameEn,
            ],

            'slug' => Str::slug($nameEn) . '-' . Str::random(5),

            'description' => [
                'en' => $this->faker->paragraph(),
                'ar' => 'وصف عربي للمنتج',
            ],

            'short_description' => [
                'en' => $this->faker->sentence(),
                'ar' => 'وصف مختصر بالعربي',
            ],
            'price' => $price,
            'sale_price' => $this->faker->boolean(40)
            ?$this->faker->numberBetween(80, $price) : null,

            'sku' => strtoupper(Str::random(10)),

            // matches migration column: stock_quantity (not "stock")
            'stock_quantity' => $stock,
            'low_stock_threshold' => $this->faker->numberBetween(3, 10),
            'is_out_of_stock' => $stock === 0,

            'gender' => $this->faker->randomElement(['men', 'women', 'unisex']),

            'is_featured' => $this->faker->boolean(),
            'is_bestseller' => $this->faker->boolean(),
            'status' => true,

            'images' => null,
        ];
    }

    /**
     * State: product is out of stock.
     */
    public function outOfStock(): static
    {
        return $this->state(fn () => [
            'stock_quantity' => 0,
            'is_out_of_stock' => true,
        ]);
    }

    /**
     * State: featured product.
     */
    public function featured(): static
    {
        return $this->state(fn () => [
            'is_featured' => true,
        ]);
    }

    /**
     * State: inactive / hidden product.
     */
    public function inactive(): static
    {
        return $this->state(fn () => [
            'status' => false,
        ]);
    }
}