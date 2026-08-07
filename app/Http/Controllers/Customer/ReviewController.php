<?php

namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Interfaces\ReviewInterface;
use App\Models\Product;
use App\Models\Review;
use App\Servicies\ReviewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ReviewController extends Controller
{
    public function __construct(public ReviewService $review)
    {
    }
    public function store(Request $request, Product $product)
    {

        $data=$request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
            
        ]);
        $this->review->createReview(
            Auth::id(),
            $product,
            $data
        );
    
        return back()->with('success', 'Review added successfully');
    }

    public function delete(Review $review){
        Gate::authorize('delete',$review);
        $this->review->deleteReview($review->id);
        return back()->with('success', 'Review deleted successfully');
    }
}
