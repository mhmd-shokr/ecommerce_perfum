<?php
namespace App\Interfaces;
Interface WishlistInterface{
    public function getUserWishlist(int $userId, int $perPage = 10);

    public function exists(int $userId, int $productId): bool;

    public function add(array $data);
    public function count(int $userId): int;
    public function remove(int $userId, int $productId): bool;
}