<?php

namespace App\Http\Controllers;

use App\Interfaces\BrandInterFace;
use App\Interfaces\CategoryInterface;
use App\Interfaces\ProductInterface;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    public function __construct(
        protected ProductInterface  $productRepository,
        protected CategoryInterface $categoryRepository,
        protected BrandInterFace    $brandRepository,
    ) {}
    public function shop(Request $request){
            $filters=$request->only([
            'search',
            'category',
            'brand',
            'min_price',
            'max_price',
            'in_stock',
            'on_sale',
            'is_new',
            'rating',
            'sort',
            ]);

            $products=$this->productRepository->filterProducts($filters);
            $categories = $this->categoryRepository->getActiveWithProductCount();
            $brands= $this->brandRepository->all();
            return view('customer.shop', compact(
                'products',
                'categories',
                'brands',
                'filters',   
            ));
    }


    public function show(string $slug){
        $product =$this->productRepository->findBySlug($slug);

        abort_if(!$product,404);
        
        $related=$this->productRepository->filterProducts([
            'category'=>$product->category_id,
        ]);
        $related=$related->where('id','!=',$product->id)
        ->take(8)->values();

        return view('customer.show', compact('product', 'related'));
    }

}
