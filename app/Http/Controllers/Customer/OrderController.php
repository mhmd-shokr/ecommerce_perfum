<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Servicies\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService){}
    public function index(){
        $orders = $this->orderService->getUserOrders(Auth::id()); 
        $ordersCount=$this->orderService->ordersCount(Auth::id());
        return view('customer.orders.index',compact('orders','ordersCount'));
    }

    public function show(Order $order){
        try{
            $order=$this->orderService->getUserOrder(Auth::id(),$order->id);
            return view('customer.orders.show',compact('order'));
        }
        catch(\Exception $e){
            abort(404);
        }
    }
    

}
