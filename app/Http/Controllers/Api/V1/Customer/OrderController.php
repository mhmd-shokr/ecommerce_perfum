<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Customer\OrderResource;
use App\Servicies\OrderService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    use ApiResponse;
    public function __construct(protected OrderService $orderService)
    {
    }
    public function index(Request $request){
        $orders = $this->orderService
        ->getUserOrders(Auth::id());

        return $this->successResponse(
            'Orders retrieved successfully',
            200
        );
    }


    public function show(int $id){
        $order=$this->orderService->getUserOrder(Auth::id(),$id);
        return $this->successResponse(
            new OrderResource($order),
            'Order retrieve successfully',
            200
        );
    }
}
