<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::orderByDesc('created_at')->get();
        return view('admin.components.edit-reviews', compact('reviews'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reviewer' => 'required|string|max:255',
            'text' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:published,pending,hidden',
        ]);
        Review::create($validated);
        return redirect()->route('admin.components.edit-reviews')->with('success', 'Review added.');
    }

    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            'reviewer' => 'required|string|max:255',
            'text' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'location' => 'nullable|string|max:255',
            'status' => 'required|in:published,pending,hidden',
        ]);
        $review->update($validated);
        return redirect()->route('admin.components.edit-reviews')->with('success', 'Review updated.');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('admin.components.edit-reviews')->with('success', 'Review deleted.');
    }
}
