<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Servicies\ReviewService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct(public ReviewService $review)
    {
    }
    public function index()
    {
        $reviews = $this->review->getAllPendingReviews();

        return view('admin.reviews.index', compact('reviews'));
    }
    public function approve(Review $review)
    {
        $this->review->approveReview($review->id);

        return back()->with('success', 'Review approved successfully.');
    }
    
}
