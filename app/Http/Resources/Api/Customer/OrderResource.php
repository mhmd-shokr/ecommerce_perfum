<?php

namespace App\Http\Resources\Api\Customer;

use App\Http\Resources\Api\OrderItemResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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

            'order_number' => $this->order_number,

            'status' => $this->status,

            'payment_status' => $this->payment_status,

            'sub_total' => (float) $this->sub_total,

            'shipping_cost' => (float) $this->shipping_cost,

            'discount' => (float) $this->discount,

            'total' => (float) $this->total,

            'address' => $this->whenLoaded('address', function () {
                return [
                    'id' => $this->address->id,
                    'city' => $this->address->city,
                    'country' => $this->address->country,
                    'address' => $this->address->address,
                ];
            }),

            'items' => OrderItemResource::collection(
                $this->whenLoaded('items')
            ),

            'created_at' => $this->created_at?->toISOString(),
        ];;
    }
}
