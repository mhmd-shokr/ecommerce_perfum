<?php

namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;

use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(){
        if(auth()->check()){
            $products=auth()->user()->Wishlists()->with('product.brand')->get()->pluck('product');
        }else{
            $ids=session('wishlist',[]);
            $products=Product::with('brand')->whereIn('id',$ids)->get();
        }
        return view('customer.wishlist',compact('products'));
    }

    public function toggle(Product $product){
        if(auth()->check()){
            $wishlist=auth()->user()->Wishlists();
            $existing=$wishlist->where('product_id',$product->id)->first();
            $existing ? $existing->delete() : $wishlist->create(['product_id'=>$product->id]);
        }else{
            $wishlist=session()->get('wishlist',[]);
            if(in_array($product->id,$wishlist)){
                //delete product from session if has been exist
                $wishlist=array_values(array_diff($wishlist,[$product->id]));
            }else{
                //add product to wishlist if not exist
                $wishlist[]=$product->id;
            }
            session()->put('wishlist',$wishlist);
        }
        return back();
    }
}
