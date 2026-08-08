<?php
namespace App\Repositries;

use App\Filters\OrderFilter;
use App\Interfaces\OrderInterface;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderInterface{
    public function __construct(public OrderFilter $orderFilter){}
    public function getUserOrders(int $userId){
        return Order::where('user_id',$userId)->latest()->paginate(8);
    }
    public function findUserOrder(int $userId,int $orderId){
        return Order::where('user_id',$userId)->with(['items.product','address'])->findOrFail($orderId);
    }

    public function getAllOrders(array $filters = [], int $perPage = 8)
        {
            $query = Order::query()
                ->with(['user:id,name']);

            $query = $this->orderFilter->apply($query, $filters);

            return $query->paginate($perPage);
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
    public function updatePaymentStatus(Order $order, string $status)
{
    return $order->update([
        'payment_status' => $status
    ]);
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
        public function recentOrders(int $count = 5)
        {
            return Order::with(['user'])
                ->latest()
                ->take($count)
                ->get();
        }
        public function monthlyRevenue()
{
    return Order::select(
            DB::raw('DATE_FORMAT(created_at,"%Y-%m") as month'),
            DB::raw('SUM(total) as revenue')
        )
        ->where('payment_status', 'paid')
        ->groupBy('month')
        ->orderBy('month')
        ->get();
}

        public function filterOrders(array $filters, int $perPage = 10)
            {
                return $this->orderFilter->apply(
                        Order::query()->with(['user:id,name,email,created_at','items','address']),
                        $filters
                    )
                    ->paginate($perPage);
            }

    
}