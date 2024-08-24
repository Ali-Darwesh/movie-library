<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Traits\ResetsAutoIncrement;
use Illuminate\Database\Eloquent\Builder;

class Movie extends Model
{
    use ResetsAutoIncrement;
    use HasFactory;
    protected $fillable = [
        'title',
        'director',
        'genre',
        'release_year',
        'description',
    ];
    public function rating(): HasOne
    {
        return $this->hasOne(Rating::class);
    }
    public function scopeByDirector($query, $director)
    {
        return $query->where('director', $director);
    }
    public function descriptionWordCount()
    {
        return str_word_count($this->description);
    }
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

    public function scopeSort(Builder $query, $sortBy, $sortOrder)
    {
        if ($sortBy) {
            return $query->orderBy($sortBy, $sortOrder);
        }
        return $query;
    }
    public function scopePaginateMovies(Builder $query, $per_page)
    {
        if ($per_page) {
            return $query->paginate($per_page);
        }
        return $query->get();
    }
}
