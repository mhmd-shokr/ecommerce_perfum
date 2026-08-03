<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Product\ProductFilterRequest;
use App\Http\Resources\Api\Customer\ProductResource; 
use App\Models\Product;
use App\Servicies\ProductService;
use App\Traits\ApiResponse;

class ProductController extends Controller
{
    use ApiResponse;
    public function __construct(public ProductService $productService){}
    public function index(ProductFilterRequest $request){
        $product=$this->productService->filterProducts($request->validated(),$request->input('per_page',10),false);
        $paginatedData = ProductResource::collection($product)->response()->getData(true);
        return $this->successResponse(
            $paginatedData ,
            'Products retrieved successfully'
        );
    }
    public function show(string $slug){
        $productData = $this->productService->getPublicProduct($slug);
        return $this->successResponse(
            $productData,
            'Product retrieved successfully.'
        );
    }
}
