<?php

namespace App\Services;

use App\Models\Rating;

class RatingService
{
    /**
     * Create Rating
     * @param array $data
     */
    public function createRating(array $data)
    {
        return Rating::create($data);
    }
    /** Update Rating
     * @param User $user, array $data
     */
    public function updateRating(Rating $rating, array $data)
    {
        // $rating = rating::findOrFail($rating->i/d); // Find the rating or fail with a 404 error

        $rating->update($data);
        return $rating;
    }
    /** delete Rating
     * @param rating $rating
     */
    public function deleteRating(Rating $rating)
    {
        $rating->delete();
        Rating::resetAutoIncrement();
        return $rating;
    }
}
