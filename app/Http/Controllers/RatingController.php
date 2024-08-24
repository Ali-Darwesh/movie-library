<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Services\ratingService;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    protected $ratingService;
    public function __construct(ratingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ratings = Rating::all();
        return response()->json($ratings, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'movie_id' => 'required',
            'rating' => 'required|integer',
            'review' => 'required|string|max:255',
        ]);
        $rating = $this->ratingService->createRating($validatedData);
        return response()->json($rating, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Rating $rating)
    {
        $wordCount = $rating->descriptionWordCount();
        return response()->json([
            'rating' => $rating,
            'word_count' => $wordCount,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rating $rating)
    {
        // return response()->json($request->all(), 200);
        $validatedData = $request->validate([

            'rating' => 'sometimes |integer',
            'review' => 'sometimes |string|max:255',
        ]);


        $rating1 = $this->ratingService->updaterating($rating, $validatedData);

        return response()->json($rating1, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(rating $rating)
    {
        $this->ratingService->deleterating($rating);
        return response()->json(null, 204);
    }
}
