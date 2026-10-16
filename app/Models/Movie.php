<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movie extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'genre',
        'release_year',
        'status',
        'rating',
        'notes',
        'is_favorite',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'decimal:1',
            'is_favorite' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeVisibleTo(Builder $query, User $user): Builder
    {
        if ($user->isAdmin()) {
            return $query;
        }

        return $query->where('user_id', $user->id);
    }
}
