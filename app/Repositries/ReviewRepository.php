<?php
namespace App\Repositries;

use App\Filters\ReviewFilter;
use App\Interfaces\ReviewInterface;
use App\Models\Product;
use App\Models\Review;

class ReviewRepository implements ReviewInterface{
    public function getAllPendingReviews(array $filters=[],int $perPage)
    {
        $query=Review::with(['user','product']);
        $query=app(ReviewFilter::class)->apply($query,$filters);
        return $query->paginate($perPage);
    }
    public function create(array $data){
        return Review::create($data);
    }

    public function update(int $id,array $data){
        $review=$this->findOrFail($id);
        $review->update($data);
        return $review->fresh();
    }

    public function delete(int $id):bool{
        return $this->findOrFail($id)->delete();

    }

    public function find(int $id){
        return Review::find($id);
    }

    public function findOrFail(int $id){
        return Review::with(['user','product'])->findOrFail($id);
    }

    public function approve(int $id)
    {
        return $this->update($id,['is_approved'=>true]);
    }
    public function reject(int $id): Review
    {
        return $this->update($id, [
            'is_approved' => false,
        ]);
    }
    public function getProductReviews(Product $product,int $perPage){
        return $product->reviews()->with('user')->where('is_approved',true)->latest()->paginate($perPage);
    }

    public function hasUserReviewed(int $userId,Product $product){
        return Review::where('product_id',$product->id)->where('user_id',$userId)
        ->exists();
    }
}