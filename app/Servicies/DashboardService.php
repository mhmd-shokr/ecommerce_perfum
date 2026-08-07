<?php
namespace App\Servicies;

use App\Interfaces\BrandInterFace;
use App\Interfaces\CategoryInterface;
use App\Interfaces\OrderInterface;
use App\Interfaces\ProductInterface;
use App\Interfaces\UserInterface;
use Illuminate\Support\Facades\Cache;

class DashboardService{
    public function __construct(
        protected OrderInterface $orderRepository,
        protected ProductInterface $productRepository,
        protected UserInterface $userRepository,
        protected CategoryInterface $categoryRepository,
        protected BrandInterFace $brandRepository,
    )
    {}

    public function getDashboardData(): array
{
    return cache::remember('dashboard.stats',now()->addMinutes(5),function(){
        return [
            'statistics' => [
                'products'   => $this->productRepository->count(),
                'categories' => $this->categoryRepository->count(),
                'brands'     => $this->brandRepository->count(),
                'users'      => $this->userRepository->count(),
                'orders'     => $this->orderRepository->getOrdersCount(),
                'revenue'    => $this->orderRepository->totalRevenue(),
            ],
    
            'orders' => [
                'pending_count'   => $this->orderRepository->pendingOrdersCount(),
                'completed_count' => $this->orderRepository->completesOrders(),
                'recent_orders'   => $this->orderRepository->recentOrders(),            ],
    
            'inventory' => [
                'low_stock_products' => $this->productRepository->lowStockProducts(),
            ],
    
            'analytics' => [
                'monthly_revenue' => $this->orderRepository->monthlyRevenue(),
            ],

            'top_selling' => $this->orderRepository->getTopSelling(),
        ];
    });
    
}
    }
