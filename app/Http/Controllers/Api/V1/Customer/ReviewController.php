<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Review\StoreReviewRequest;
use App\Http\Resources\Api\Customer\ReviewResource;
use App\Interfaces\ReviewInterface;
use App\Models\Product;
use App\Models\Review;
use App\Servicies\ReviewService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ReviewController extends Controller
{
    public function __construct(public ReviewService $reviewService){}

    use ApiResponse;
    public function index(Product $product){
        $reviews=$this->reviewService->getProductReviews($product);
        return $this->successResponse(
            ReviewResource::Collection($reviews),
            'Reviews retrieved successfully',
        );
    }

    public function store(StoreReviewRequest $request,Product $product){
        $review=$this->reviewService->createReview(
            Auth::id(),
            $product,
            $request->validated()
        );
        return $this->successResponse(
            new ReviewResource($review),
            'Review submitted successfully and is waiting for approval',
            201
        );
    }

    public function destroy(Review $review)
    {
        Gate::authorize('delete', $review);

        $this->reviewService->deleteReview($review->id);

        return $this->successResponse(
            null,
            'Review deleted successfully'
        );
    }
}
