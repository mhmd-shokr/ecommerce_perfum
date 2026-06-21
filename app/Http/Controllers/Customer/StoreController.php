<?php

namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Servicies\BrandService;
use App\Servicies\CategorySevice;
use App\Servicies\ProductService;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    protected $proService;
    protected $catService;
    protected $brService;
    public function __construct(ProductService $proService,CategorySevice $catService,BrandService $brService){
        $this->proService=$proService;
        $this->catService=$catService;
        $this->brService=$brService;
    }
    public function home(){
        $categories=$this->catService->getCategories();
        $brands=$this->brService->getBrands();
        $products=$this->proService->getPaginatedProducts(8);

        return view('customer.home',compact('categories','brands','products'));
    }

    public function show(string $slug){
        $product = $this->proService->getProductBySlug($slug);
        if (!$product) {
            abort(404);
        }
        $relatedProducts=$this->proService->getRelatedProduct($product);
        return view('customer.show', compact('product','relatedProducts'));
    }
    
    

}
