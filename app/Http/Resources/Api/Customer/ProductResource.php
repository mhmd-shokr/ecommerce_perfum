<?php

namespace App\Http\Resources\Api\Customer;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'name' => $this->name,
            'slug' => $this->slug,

            'description' => $this->description,
            'short_description' => $this->short_description,

            'price' => (float) $this->price,

            'sale_price' => $this->sale_price !== null
                ? (float) $this->sale_price
                : null,

            'gender' => $this->gender,

            'is_featured' => (bool) $this->is_featured,
            'is_bestseller' => (bool) $this->is_bestseller,
            'is_new' => (bool) $this->is_new,

            'images' => $this->images
                ? asset(Storage::url($this->images))
                : null,

            'category' => $this->whenLoaded('category', function () {
                return [
                    'id' => $this->category->id,
                    'name' => $this->category->name,
                ];
            }),

            'brand' => $this->whenLoaded('brand', function () {
                return [
                    'id' => $this->brand->id,
                    'name' => $this->brand->name,
                ];
            }),

            'average_rating' => $this->when(
                isset($this->average_rating),
                round((float) $this->average_rating, 1)
            ),

            'reviews_count' => $this->when(
                isset($this->reviews_count),
                $this->reviews_count
            ),

        ];
    }
}