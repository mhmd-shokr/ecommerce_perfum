<?php
namespace App\Servicies;

use App\Interfaces\ReviewInterface;
use App\Models\Product;
use Illuminate\Validation\ValidationException;

class ReviewService{
    public function __construct(public ReviewInterface $reviewRepository)
    {
    }
    public function getAllPendingReviews(array $filters =[],int $perPage = 10)
{
    return $this->reviewRepository->getAllPendingReviews($filters,$perPage);
}
    public function getProductReviews(Product $product,int $per_page=10){
        return $this->reviewRepository->getProductReviews($product,$per_page);
    }

    public function createReview(int $userId,Product $product,array $data){
        if($this->reviewRepository->hasUserReviewed($userId,$product)){
            throw ValidationException::withMessages([
                'review'=>__('You have already reviewed this product')
            ]);
        }

        return $this->reviewRepository->create([
            'user_id'=>$userId,
            'product_id'=>$product->id,
            'rating'=>$data['rating'],
            'comment'=>$data['comment'],
            'is_approved'=>false
        ]);
    }

    public function updateReview(int $reviewId,array $data){
        return $this->reviewRepository->update($reviewId,$data);
    }

    public function deleteReview(int $reviewId)
    {
        return $this->reviewRepository->delete($reviewId);
    }

    public function approveReview(int $reviewId){
        return $this->reviewRepository->approve($reviewId);
    }

    public function rejectReview(int $reviewId){
        return $this->reviewRepository->reject($reviewId);
    }
}