<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Servicies\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService){}
    public function index(){
        $orders=$this->orderService->getAllOrders();
        $ordersCount=$this->orderService->getOrdersCount();
        $pendingOrdersCount=$this->orderService->orderPending();
        return view('admin.orders.index',compact('orders','ordersCount','pendingOrdersCount'));
    }

    public function show(Order $order){
        $order=$this->orderService->findOrder($order->id);
        return view('admin.orders.show',compact('order'));
    }

    public function update(Request $request,Order $order){
        $validated=$request->validate(['status'=>'required|in:pending,processing,shipped,delivered,cancelled']);
        $this->orderService->updateStatus($order,$validated);
        return back()->with('success','order status updated success');
        }

}
