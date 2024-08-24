<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Services\MovieService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    protected $movieService;
    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    // $allMovies = []; // Initialize an empty array
    // $totalPages = Movie::paginate(2)->lastPage(); // Get the total number of pages

    // foreach (range(1, $totalPages) as $page) {
    //     $movies = Movie::paginate(2, ['*'], 'page', $page); // Fetch the movies for the current page
    //     $allMovies[$page] = $movies->items(); // Store the current page's movies in the array
    // }
    //==========
    public function index(Request $request)
    {
        $filters = $request->only(['director', 'genre']);
        $sortBy = $request->query('sort_by');
        $sortOrder = $request->query('sort_order');
        $perPage = $request->query('per_page');

        $movies = Movie::filter($filters)
            ->sort($sortBy, $sortOrder)
            ->with('ratings')
            ->paginateMovies($perPage);


        //===========
        // $movies = Movie::all();
        // $movies = Movie::with('ratings')->get();

        return response()->json(['movies' => $movies], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|unique:movies|max:255',
            'director' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'release_year' => 'required|integer',
            'description' => 'required|string|max:255',
        ]);
        $movie = $this->movieService->createMovie($validatedData);
        return response()->json($movie, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie)
    {
        $wordCount = $movie->descriptionWordCount();
        $movies = Movie::with('ratings')->findOrFail($movie->id);

        return response()->json([
            'movie' => $movies,
            'word_count' => $wordCount,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie)
    {
        // return response()->json($request->all(), 200);
        $validatedData = $request->validate([
            'title' => 'sometimes|unique:movies|max:255',
            'director' => 'sometimes | string|max:255',
            'genre' => 'sometimes|required|max:255',
            'release_year' => 'sometimes |integer',
            'description' => 'sometimes|string|max:255',
        ]);


        $movie1 = $this->movieService->updateMovie($movie, $validatedData);

        return response()->json($movie1, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        $this->movieService->deleteMovie($movie);
        return response()->json(null, 204);
    }
}
