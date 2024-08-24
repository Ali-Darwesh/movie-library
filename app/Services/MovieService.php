<?php

namespace App\Services;

use App\Models\Movie;
use Illuminate\Support\Facades\DB;
use Psy\CodeCleaner\ReturnTypePass;

class MovieService
{


    public function createMovie(array $data)
    {
        return Movie::create($data);
    }
    public function updateMovie(Movie $movie, array $data)
    {
        // $movie = Movie::findOrFail($movie->i/d); // Find the movie or fail with a 404 error

        $movie->update($data);
        return $movie;
    }
    public function deleteMovie(Movie $movie)
    {
        $movie->delete();
        Movie::resetAutoIncrement();
        return $movie;
    }
}
