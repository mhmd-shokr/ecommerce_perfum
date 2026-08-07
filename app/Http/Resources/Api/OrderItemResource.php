<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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

            'product' => 
                new ProductResource($this->whenLoaded('product')),
            

            'quantity' => $this->quantity,
            'price' =>  $this->unit_price,
            'subtotal' =>  $this->quantity * $this->unit_price,
        ];
    }
}
