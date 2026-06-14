<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'brand'])
            ->latest()
            ->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    public function store(ProductRequest $request)
    {
        $data = $request->validated();

        Product::create([
            'category_id' => $data['category_id'],
            'brand_id' => $data['brand_id'],

            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'short_description' => $data['short_description'] ?? null,

            'slug' => $data['slug']
                ?? Str::slug($data['name']['en'] . '-' . uniqid()),

            'price' => $data['price'],
            'sale_price' => $data['sale_price'] ?? null,

            'sku' => $data['sku'],
            'stock' => $data['stock'],

            'gender' => $data['gender'],

            'is_featured' => $data['is_featured'] ?? false,
            'is_bestseller' => $data['is_bestseller'] ?? false,
            'status' => $data['status'] ?? true,
        ]);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product created successfully');
    }

    public function show(string $id)
    {
        $product = Product::with(['category', 'brand'])->findOrFail($id);

        return view('admin.products.show', compact('product'));
    }

    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(ProductRequest $request, string $id)
    {
        $product = Product::findOrFail($id);
        $data = $request->validated();

        $product->update([
            'category_id' => $data['category_id'],
            'brand_id' => $data['brand_id'],

            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'short_description' => $data['short_description'] ?? null,

            'slug' => Str::slug($data['name']['en'] . '-' . $product->id),

            'price' => $data['price'],
            'sale_price' => $data['sale_price'] ?? null,

            'sku' => $data['sku'],
            'stock' => $data['stock'],

            'gender' => $data['gender'],

            'is_featured' => $data['is_featured'] ?? false,
            'is_bestseller' => $data['is_bestseller'] ?? false,
            'status' => $data['status'] ?? true,
        ]);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully');
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return back()->with('success', 'Product deleted successfully');
    }
}