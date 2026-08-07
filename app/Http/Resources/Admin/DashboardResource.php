<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'statistics' => [
                'products'   => $this['statistics']['products'],
                'categories' => $this['statistics']['categories'],
                'brands'     => $this['statistics']['brands'],
                'users'      => $this['statistics']['users'],
                'orders'     => $this['statistics']['orders'],
                'revenue'    => $this['statistics']['revenue'],
            ],

            'orders' => [
                'pending_count'   => $this['orders']['pending_count'],
                'completed_count' => $this['orders']['completed_count'],
                'recent_orders'  => $this['orders']['recent_orders'],
            ],

            'inventory' => [
                'low_stock_products' => $this['inventory']['low_stock_products'],
            ],
            'analytics' => [
                    'monthly_revenue' => $this['analytics']['monthly_revenue'],
                ],
            'top_selling' => $this['top_selling'],
        ];
    }
}
