<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Servicies\InvoiceService;
use App\Servicies\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService , protected InvoiceService $invoiceService){}
    public function index(){
        $orders=$this->orderService->getAllOrders();
        $ordersCount=$this->orderService->getOrdersCount();
        $pendingOrdersCount=$this->orderService->pendingOrdersCount();
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

        public function updatePaymentStatus(Request $request, Order $order)
        {
            $validated = $request->validate([
                'payment_status' => 'required|in:pending,paid,failed,refunded',
            ]);
        
            try {
                $this->orderService->updatePaymentStatus($order, $validated['payment_status']);
                return back()->with('success', __('Payment status updated'));
            } catch (\Exception $e) {
                return back()->with('error', $e->getMessage());
            }
        }

        public function invoice(Order $order){
            Gate::authorize('view',$order);
            return $this->invoiceService->download($order);
        }
}
