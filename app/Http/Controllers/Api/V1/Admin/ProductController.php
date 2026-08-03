<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\Product\ProductFilterRequest;
use App\Http\Requests\Api\Admin\Product\StoreProductRequest;
use App\Http\Requests\Api\Admin\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Servicies\ProductService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponse;
    public function __construct(public ProductService $productService){}

    public function index(ProductFilterRequest $request){
        $products=$this->productService->filterProducts($request->validated(),$request->input('per_page',10),true);
        return $this->successResponse(
            ProductResource::collection($products),
            'Products retrieved successfully'
        );
    }
    public function store(StoreProductRequest $request){
        $product=$this->productService->createProduct($request->validated());
        return $this->successResponse(
            new ProductResource($product),
            'Product created successfully.',
            201
        );
    }

    public function show(Product $product)
{
    $product = $this->productService->getAdminProduct($product);

    return $this->successResponse(
        new ProductResource($product),
        'Product retrieved successfully.'
    );
}
    public function update(UpdateProductRequest $request,Product $product){
        $product=$this->productService->updateProduct($product,$request->validated());
        return $this->successResponse(
            new ProductResource($product),
            'Product updated successfully.',
            200
        );
    }

    public function destroy(Product $product)
    {
        $deleted = $this->productService->deleteProduct($product->id);
    
        if (!$deleted) {
            return $this->errorResponse(
                'Product deletion failed.',
                400
            );
        }
    
        return $this->successResponse(
            null,
            'Product deleted successfully.',
            200
        );
    }
}
