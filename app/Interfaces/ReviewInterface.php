<?php
namespace App\Interfaces;

use App\Models\Product;


Interface ReviewInterface{
    public function getAllPendingReviews(array $filters=[],int $perPage);
    public function create(array $data);

    public function update(int $id,array $data);

    public function delete(int $id);

    public function find(int $id);

    public function findOrFail(int $id);

    public function approve(int $id);

    public function reject(int $id);
    public function getProductReviews(Product $product,int $perPage);
    public function hasUserReviewed(int $userId,Product $product);

}