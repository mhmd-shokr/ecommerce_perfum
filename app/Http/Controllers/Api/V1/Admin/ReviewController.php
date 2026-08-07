<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ReviewResource;
use App\Servicies\ReviewService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected ReviewService $reviewService
    ) {}

    public function index(Request $request)
    {
        $reviews = $this->reviewService->getAllPendingReviews(
            $request->all(),
            $request->integer('per_page', 10)
        );

        return $this->successResponse(
            ReviewResource::collection($reviews),
            'Reviews retrieved successfully'
        );
    }
    public function approve(string $id)
    {
        $review = $this->reviewService->approveReview($id);
        return $this->successResponse(
            new ReviewResource($review),
            'Review approved successfully'
        );
    }

    public function reject(string $id)
    {
        $review = $this->reviewService->rejectReview($id);

        return $this->successResponse(
            new ReviewResource($review),
            'Review rejected successfully'
        );
    }

    public function destroy(string $id)
{
    $this->reviewService->deleteReview($id);
    return $this->successResponse(
        null,
        'Review deleted successfully.'
    );
}
}
