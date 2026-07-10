<?php
namespace App\Repositries;

use App\Interfaces\OrderInterface;
use App\Models\Order;
use App\Models\Product;
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
    public function updateStatus(Order $order, array $data)
    {
        $order->update($data);

        return $order->fresh();
    }

    public function OrdersCount(int $userId){
        return Order::where('user_id',$userId)->count();
    }

    public function getOrdersCount()
    {
        return Order::count();
    }

    public function pendingOrdersCount(){
        return Order::where('status','pending')->count();
    }

public function pendingOrders()
{
    return Order::with('user')
                ->where('status', 'pending')
                ->latest()
                ->take(5)
                ->get();
}

    public function completesOrders()
{
    return Order::where('status', 'delivered')->count();
}
public function totalRevenue()
{
    return Order::where('payment_status', 'paid')
                ->sum('total');
}

public function getTopSelling(int $count = 5){
    return Product::withSum('orderItems','quantity')->orderByDesc('order_items_sum_quantity')->
    take($count)->get();
}
}