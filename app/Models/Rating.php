<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\ResetsAutoIncrement;

class Rating extends Model
{ // use trait
    use ResetsAutoIncrement;
    use HasFactory;
    protected $fillable = [
        'user_id',
        'movie_id',
        'rating',
        'review'
    ];
    //relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }
};
