<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Customer\WishlistResource;
use App\Models\Product;
use App\Servicies\WishlistService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    use ApiResponse;
    public function __construct(
        protected WishlistService $wishlistService
    ) {}

    public function index(Request $request)
    {
        $wishlist = $this->wishlistService->getWishlist(
            Auth::id(),
            $request->integer('per_page', 10)
        );

        return $this->successResponse(
            WishlistResource::collection($wishlist),
            'Wishlist retrieved successfully.'
        );
    }

    public function store(Product $product)
    {
        $wishlist = $this->wishlistService->addProduct(
            Auth::id(),
            $product
        );

        return $this->successResponse(
            new WishlistResource($wishlist->load([
                'product.brand',
                'product.category'
            ])),
            'Product added to wishlist.',
            201
        );
    }

    public function check(Product $product)
    {
        $in_wishlist=$this->wishlistService->checkProduct(Auth::id(),$product);
        return $this->successResponse(
            $in_wishlist,
            'in_wishlist'
        );
    }
    public function count()
{
    $count=$this->wishlistService->count(Auth::id());
    return $this->successResponse(
        $count,
        'count retrieved successfully'
    );
}
    public function destroy(Product $product)
    {
        $this->wishlistService->removeProduct(
            Auth::id(),
            $product
        );

        return $this->successResponse(
            null,
            'Product removed from wishlist.'
        );
    }
    
}
