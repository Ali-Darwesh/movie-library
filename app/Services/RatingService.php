<?php

namespace App\Services;

use App\Models\Rating;

class ratingService
{

    public function createRating(array $data)
    {
        return Rating::create($data);
    }
    public function updateRating(Rating $rating, array $data)
    {
        // $rating = rating::findOrFail($rating->i/d); // Find the rating or fail with a 404 error

        $rating->update($data);
        return $rating;
    }
    public function deleteRating(rating $rating)
    {
        $rating->delete();
        Rating::resetAutoIncrement();
        return $rating;
    }
}
