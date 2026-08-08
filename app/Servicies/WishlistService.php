<?php
namespace App\Servicies;

use App\Interfaces\WishlistInterface;
use App\Models\Product;
use Illuminate\Validation\ValidationException;

class WishlistService{
    public function __construct(public WishlistInterface $wishlistRepo)
    {
    }
    public function getWishlist(int $userId, int $perPage = 10)
    {
        return $this->wishlistRepo->getUserWishlist($userId, $perPage);
    }

    public function addProduct(int $userId, Product $product)
    {
        if ($this->wishlistRepo->exists($userId, $product->id)) {
            throw ValidationException::withMessages([
                'wishlist' => __('Product already exists in wishlist.'),
            ]);
        }

        return $this->wishlistRepo->add([
            'user_id' => $userId,
            'product_id' => $product->id,
        ]);
    }

    public function removeProduct(int $userId, Product $product)
    {
        if (! $this->wishlistRepo->exists($userId, $product->id)) {
            throw ValidationException::withMessages([
                'wishlist' => __('Product not found in wishlist.'),
            ]);
        }

        return $this->wishlistRepo->remove($userId, $product->id);
    }

    public function count(int $userId): int
{
    return $this->wishlistRepo->count($userId);
}
    public function checkProduct(int $userId, Product $product): bool
        {
            return $this->wishlistRepo->exists($userId, $product->id);
        }
}