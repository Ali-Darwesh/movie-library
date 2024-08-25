<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Services\MovieService;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Exception;

class MovieController extends Controller
{
    protected $movieService;
    /**
     * Constracor to inject Movie Service
     * @param MovieService $movieService
     */
    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    /**
     * Display a listing of the Movies/pagination / sort by release_year and sort_order
     *  /filtering by directeror genre or both.
     */
    public function index(Request $request)
    {
        try {
            $filters = $request->only(['director', 'genre']);
            $sortBy = $request->query('sort_by');
            $sortOrder = $request->query('sort_order');
            $perPage = $request->query('per_page');

            $movies = Movie::filter($filters)
                ->sort($sortBy, $sortOrder)
                ->with('rating')
                ->paginateMovies($perPage);

            return response()->json(['movies' => $movies], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve movies', 'message' => $e->getMessage()], 500);
        }
    }
    /**
     * Store a newly created movie in database
     * @param Request $request
     * @return \Illuminate\HTTP\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|unique:movies|max:255',
                'director' => 'required|string|max:255',
                'genre' => 'required|string|max:255',
                'release_year' => 'required|integer',
                'description' => 'required|string|max:255',
            ]);

            $movie = $this->movieService->createMovie($validatedData);
            return response()->json($movie, 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to create movie', 'message' => $e->getMessage()], 500);
        }
    }
    /**
     * show a movie
     * @param Movie $movie
     * @return \Illuminate\HTTP\JsonResponse
     */
    public function show(Movie $movie)
    {
        try {
            $movie = Movie::with('rating')->findOrFail($movie->id);


            return response()->json([
                'movie' => $movie
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve movie details', 'message' => $e->getMessage()], 500);
        }
    }
    /**
     * ubdate movie data in database
     * @param Request $request, Movie $movie
     * @return \Illuminate\HTTP\JsonResponse
     */
    public function update(Request $request, Movie $movie)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'sometimes|unique:movies|max:255',
                'director' => 'sometimes|string|max:255',
                'genre' => 'sometimes|max:255',
                'release_year' => 'sometimes|integer',
                'description' => 'sometimes|string|max:255',
            ]);

            $movie1 = $this->movieService->updateMovie($movie, $validatedData);

            return response()->json($movie1, 201);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to update movie', 'message' => $e->getMessage()], 500);
        }
    }
    /**
     * delete movie data in database
     * @param Movie $movie
     * @return \Illuminate\HTTP\JsonResponse
     */
    public function destroy(Movie $movie)
    {
        try {
            $this->movieService->deleteMovie($movie);
            return response()->json(null, 204);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to delete movie', 'message' => $e->getMessage()], 500);
        }
    }
}
