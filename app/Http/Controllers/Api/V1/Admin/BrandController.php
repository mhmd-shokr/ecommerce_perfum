<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Brand\StoreBrandRequest;
use App\Http\Requests\Api\Brand\UpdateBrandRequest;
use App\Http\Requests\BrandRequest;
use App\Http\Resources\Admin\BrandResource;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use  App\Servicies\BrandService;
class BrandController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function __construct(
        protected BrandService $brandService
    ) {}
    public function index()
    {
        $brands=$this->brandService->getAllBrands(2);
        return $this->successResponse(
            BrandResource::collection($brands),
            'Brands retrieved successfully'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        $brand=$this->brandService->createBrand($request->validated());
        return $this->successResponse(
            new BrandResource($brand),
            'Brand created successfully',
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brand=$this->brandService->getBrandById($id);
        return $this->successResponse(
            new BrandResource($brand),
            'Brand retrieved successfully',
            200
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, string $id)
    {
        
        $brand=$this->brandService->updateBrand($id,$request->validated());
        return $this->successResponse(
            new BrandResource($brand),
            'Brand updated successfully',
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand=$this->brandService->deleteBrand($id);
        if(!$brand){
            return $this->errorResponse(
                'brand deletion failed.',
                400
            );
        }
        return $this->successResponse(
            null,
            'brand deleted successfully.',
            200
        );
    }
}
