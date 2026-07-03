<?php
namespace App\Interfaces;

use App\Models\Order;

Interface OrderInterface{
    public function getUserOrders(int $userId);
    public function findUserOrder(int $userId,int $orderId);
    public function OrdersCount(int $userId);

    //admin
    public function getAllOrders();

    public function findOrder(int $orderId);
    public function updateStatus(Order $order,array $data);
    
    public function getOrdersCount();

    public function pendingOrders();
}