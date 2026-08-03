<?php

namespace App\Http\Resources;

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
            'sale_price' => $this->sale_price
                ? (float) $this->sale_price
                : null,

                
            'sku' => $this->sku,
            'gender' => $this->gender,

            'stock_quantity' => $this->stock_quantity,
            'is_out_of_stock' => $this->is_out_of_stock,

            'is_featured' => $this->is_featured,
            'is_bestseller' => $this->is_bestseller,
            'is_new' => $this->is_new,

            'images' => $this->images
                ? asset(Storage::url($this->images))
                : null,
            
            'category'=>$this->whenLoaded('category',function(){
                return[
                    'id'=>$this->category->id,
                    'name'=>$this->category->name,
                ];
            }),
            'brand'=>$this->whenLoaded('brand',function(){
                return[
                    'id'=>$this->brand->id,
                    'name'=>$this->brand->name,
                ];
            }),
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
