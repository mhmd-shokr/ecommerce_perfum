<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Orders\UpdateOrderStatusRequest;
use App\Http\Resources\Api\OrderResource;
use App\Models\Order;
use App\Servicies\OrderService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ApiResponse;
    public function __construct(protected OrderService $orderService)
    {
    }
    public function index(Request $request){
        $orders = $this->orderService
        ->getOrders($request->all());

        return $this->successResponse(
            OrderResource::collection($orders),
            'Orders retrieved successfully',
            200
        );
    }

    public function updateStatus(
        UpdateOrderStatusRequest $request,
        Order $order
    )
    {
        $order = $this->orderService
            ->updateStatus(
                $order,
                $request->validated()
            );
    
        return $this->successResponse(
            new OrderResource($order),
            'Orders updated successfully',
            200
        );
    }

    public function show(Order $order)
{
    $order = $this->orderService->findOrder($order->id);

    return $this->successResponse(
        new OrderResource($order),
        'Order retrieved successfully',
        200
    );
}
}
