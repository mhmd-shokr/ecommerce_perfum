<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Servicies\ProductService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponse;
    public function __construct(protected ProductService $productService)
    {
    }
    public function index(Request $request){
        $products=$this->productService->getPaginatedProducts($request->all(),$request->integer('per_page',12));
    
        return $this->successResponse(
            ProductResource::collection($products),
            'Products retrieved successfully.'
        );
    }
    
}
