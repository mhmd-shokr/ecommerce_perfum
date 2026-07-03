<?php
namespace  App\Servicies;

use App\Models\Order;
use App\Repositries\OrderRepository;

class OrderService{
    public function __construct(protected OrderRepository $orderRepository){}

    public function getUserOrders(int $userId){
        return $this->orderRepository->getUserOrders($userId);
    }

    public function getUserOrder(int $userId,int $orderId){
        return $this->orderRepository->findUserOrder($userId,$orderId);
    }

    public function getAllOrders(){
        return $this->orderRepository->getAllOrders();
    }
    public function findOrder(int $orderId){
        return $this->orderRepository->findOrder($orderId);
    }

    public function updateStatus(Order $order,array $data){
        return $this->orderRepository->updateStatus($order,$data);
    }
    public function ordersCount(int $userId){
        return $this->orderRepository->OrdersCount($userId);
    }

    public function getOrdersCount(){
        return $this->orderRepository->getOrdersCount();
    }

    public function orderPending(){
        return $this->orderRepository->pendingOrders();
    }
}
