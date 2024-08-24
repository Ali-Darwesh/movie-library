<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Traits\ResetsAutoIncrement;

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
    public function scopeByDirector($query, $director)
    {
        return $query->where('director', $director);
    }
    public function descriptionWordCount()
    {
        return str_word_count($this->description);
    }
    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }
}
