<?php
namespace App\Servicies;

use App\Interfaces\OrderInterface;
use App\Interfaces\ProductInterface;
use App\Interfaces\UserInterface;
use Illuminate\Support\Facades\Cache;

class DashboardService{
    public function __construct(
        protected OrderInterface $orderRepository,
        protected ProductInterface $productRepository,
        protected UserInterface $userRepository,
    )
    {}

    public function getDashboardData(): array
{
    return cache::remember('dashboard.stats',now()->addMinutes(5),function(){
        return [
            'ordersCount'      => $this->orderRepository->getOrdersCount(),
            'topSelling'       => $this->orderRepository->getTopSelling(),
            'pendingOrders'    => $this->orderRepository->pendingOrders(),   
            'completedOrders'  => $this->orderRepository->completesOrders(),
            'totalRevenue'     => $this->orderRepository->totalRevenue(),
            'productsCount'    => $this->productRepository->count(),
            'lowStockProducts' => $this->productRepository->lowStockProducts(),
            'usersCount'       => $this->userRepository->count(),
        ];
    });
    
}
    }
