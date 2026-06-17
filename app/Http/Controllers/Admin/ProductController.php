<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Servicies\ProductService;
use App\Servicies\CategorySevice;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    protected $services;
    protected $categoryService;
    public function __construct(ProductService $services,CategorySevice $categoryService)
    {
        $this->services=$services;
        $this->categoryService=$categoryService;
    }
    public function index()
    {
        $products =$this->services->getPaginatedProducts(8);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories=$this->categoryService->getCategories();
        $brands=Brand::all();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $product=$this->services->createProduct($data);
        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully');
    }


    public function edit(Product $product)
    {
        $product->load(['category', 'brand', 'sizes', 'fragranceNotes']);
        $categories = $this->categoryService->getCategories();
        $brands = Brand::all();
    
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(ProductRequest $request,Product $product)
    {
        $validated = $request->validated();
        $product = $this->services->updateProduct($product->id,$validated);
        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully');
    }

    public function destroy(string $id)
    {
        $this->services->deleteProduct($id);

        return back()->with('success', 'Product deleted successfully');
    }
}