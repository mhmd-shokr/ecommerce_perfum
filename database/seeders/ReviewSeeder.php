<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users=User::all();
        $products=Product::all();

        Review::factory(100)->make()
            ->each(function($review) use($users,$products){
                $review->User_id=$users->random()->id;
                $review->product_id=$products->random()->id;
                $review->save();
            });
    }
}
