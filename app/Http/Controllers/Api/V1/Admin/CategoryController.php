<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Category\StoreCategoryRequest;
use App\Http\Requests\Api\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Servicies\CategoryService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use ApiResponse;
    public function __construct(public CategoryService $categoryService){}
    public function index(Request $request)
    {
        $categories=$this->categoryService->getAllCategories($request->integer('per_page',10));
        return $this->successResponse(
            CategoryResource::collection($categories),
            'Categories retrieved successfully',
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $category=$this->categoryService->createCategory($request->validated());
        return $this->successResponse(
            new CategoryResource($category),
            'Category created successfully',
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category=$this->categoryService->getCategoryById($id);
        return $this->successResponse(
            new CategoryResource($category),
            'Category retrieved successfully',
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        $category=$this->categoryService->updateCategory($id,$request->validated());
        return $this->successResponse(
            new CategoryResource($category),
            'Category updated successfully',
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleted = $this->categoryService->deleteCategory($id);
    
        if (!$deleted) {
            return $this->errorResponse(
                'Category deletion failed.',
                400
            );
        }
    
        return $this->successResponse(
            null,
            'Category deleted successfully.',
            200
        );
    }
}
