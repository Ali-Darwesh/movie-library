<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Traits\ResetsAutoIncrement;
use Illuminate\Database\Eloquent\Builder;

class Movie extends Model
{
    // use trait
    use ResetsAutoIncrement;
    use HasFactory;
    protected $fillable = [
        'title',
        'director',
        'genre',
        'release_year',
        'description',
    ];
    //one to one relation with rating
    public function rating(): HasOne
    {
        return $this->hasOne(Rating::class);
    }

    public function descriptionWordCount()
    {
        return str_word_count($this->description);
    }
    //Scope to filter data on director or genre
    public function scopeFilter(Builder $query, $filters)
    {
        if (!empty($filters['director'])) {
            $query->where('director', 'like', '%' . $filters['director'] . '%');
        }

        if (!empty($filters['genre'])) {
            $query->where('genre', 'like', '%' . $filters['genre'] . '%');
        }

        return $query;
    }
    /**
     * Scope to sort on release_year ordered by sortOrder
     * @param Builder $query, $sortBy, $sortOrder
     *
     */
    public function scopeSort(Builder $query, $sortBy, $sortOrder)
    {
        if ($sortBy) {
            return $query->orderBy($sortBy, $sortOrder);
        }
        return $query;
    }
    /**
     * Pagination 
     * @param Builder $query, $per_page
     */
    public function scopePaginateMovies(Builder $query, $per_page)
    {
        if ($per_page) {
            return $query->paginate($per_page);
        }
        return $query->get();
    }
}
