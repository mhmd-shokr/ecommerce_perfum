<?php
namespace App\Repositries;

use App\Interfaces\OrderInterface;
use App\Models\Order;
use Override;

class OrderRepository implements OrderInterface{
    public function getUserOrders(int $userId){
        return Order::where('user_id',$userId)->latest()->paginate(8);
    }
    public function findUserOrder(int $userId,int $orderId){
        return Order::where('user_id',$userId)->with(['items.product','address'])->findOrFail($orderId);
    }

    public function getAllOrders(){
        return Order::latest()->paginate(8);
    }

    public function findOrder(int $orderId){
        return Order::with(['items.product','user','address'])->findOrFail($orderId);
    }
    public function updateStatus(Order $order,array $data){
        return $order->update($data);
    }

    public function OrdersCount(int $userId){
        return Order::where('user_id',$userId)->count();
    }

    public function getOrdersCount()
    {
        return Order::count();
    }

    public function pendingOrders(){
        return Order::where('status','pending')->count();
    }

}