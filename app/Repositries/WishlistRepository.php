<?php
namespace App\Repositries;

use App\Interfaces\WishlistInterface;
use App\Models\Wishlist;

class WishlistRepository implements WishlistInterface{
    public function getUserWishlist(int $userId, int $perPage = 10){
        return Wishlist::with(['product.brand','product.category'])->
        where('user_id',$userId)->latest()->paginate($perPage);
    }
    public function exists(int $userId, int $productId): bool
    {
        return Wishlist::where([
            'user_id' => $userId,
            'product_id' => $productId,
        ])->exists();
    }

    public function add(array $data)
    {
        return Wishlist::create($data);
    }
    public function remove(int $userId, int $productId): bool
    {
        return Wishlist::where([
            'user_id' => $userId,
            'product_id' => $productId,
        ])->delete();
    }

    public function count(int $userId): int
    {
        return Wishlist::where('user_id', $userId)->count();
    }
}