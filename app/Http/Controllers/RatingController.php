<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Rating;
use App\Services\ratingService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Exception;

class RatingController extends Controller
{
    protected $ratingService;
    /**
     * Constracor to inject Rating Service
     * @param RatingService $ratingService
     */
    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }
    /**
     * Display a listing of the resource.
     * @return \Illuminate\HTTP\JsonResponse
     */
    public function index()
    {
        try {
            $ratings = Rating::all();
            return response()->json($ratings, 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve ratings', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created rating in storage.
     * @param Request $request
     * @return \Illuminate\HTTP\JsonResponse
     */

    public function store(Request $request)
    {
        try {
            $movie = Movie::findOrFail($request->input('movie_id'));

            if ($movie->rating) {
                // Throw a validation error if a rating already exists
                throw ValidationException::withMessages([
                    'rating' => 'This movie already has a rating.',
                ]);
            }
            $validatedData = $request->validate([
                'user_id' => 'sometimes',
                'movie_id' => 'sometimes',
                'rating' => 'sometimes|integer|min:1|max:5',
                'review' => 'sometimes|string|max:255',
            ]);
            $rating = $this->ratingService->createRating($validatedData);
            return response()->json($rating, 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to create rating', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * display rating data 
     * @param Rating $rating
     * @return \Illuminate\HTTP\JsonResponse
     */
    public function show(Rating $rating)
    {
        try {
            return response()->json([
                'rating' => $rating
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve rating details', 'message' => $e->getMessage()], 500);
        }
    }
    /**
     * ubdate rating data in database
     * @param Request $request, Rating $rating
     * @return \Illuminate\HTTP\JsonResponse
     */
    public function update(Request $request, Rating $rating)
    {
        try {
            // return response()->json($request->all(), 200);
            $validatedData = $request->validate([

                'rating' => 'sometimes |integer|min:1|max:5',
                'review' => 'sometimes |string|max:255',
            ]);


            $rating1 = $this->ratingService->updateRating($rating, $validatedData);

            return response()->json($rating1, 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to update rating', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the rating from storage.
     *  @param Rating $rating
     * @return \Illuminate\HTTP\JsonResponse
     */

    public function destroy(Rating $rating)
    {
        try {
            $this->ratingService->deleteRating($rating);
            return response()->json(null, 204);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to delete rating', 'message' => $e->getMessage()], 500);
        }
    }
}
