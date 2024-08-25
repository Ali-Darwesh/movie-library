<?php

namespace App\Services;

use App\Models\Movie;
use Illuminate\Support\Facades\DB;
use Psy\CodeCleaner\ReturnTypePass;

class MovieService
{

    /**
     * Create Movie
     * @param array $data
     */
    public function createMovie(array $data)
    {
        return Movie::create($data);
    }
    /**
     * Update Movie
     * @param Movie $movie, array $data
     */
    public function updateMovie(Movie $movie, array $data)
    {
        // $movie = Movie::findOrFail($movie->i/d); // Find the movie or fail with a 404 error

        $movie->update($data);
        return $movie;
    }
    /** delete Movie
     * @param Movie $movie
     */
    public function deleteMovie(Movie $movie)
    {
        $movie->delete();
        //Reset Auto Increment ID
        Movie::resetAutoIncrement();
        return $movie;
    }
}
