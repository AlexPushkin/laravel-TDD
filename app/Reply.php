<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reply extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    protected $with = ['owner', 'favorites'];

    public function owner(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function favorites()
    {
        return $this->morphMany(Favorites::class, 'favorited');
    }

    public function favorite(int $userId)
    {
        $attributes = ['user_id' => $userId];
        if (!$this->favorites()->where($attributes)->exists()) {
            return $this->favorites()->create($attributes);
        }
    }

    public function isFavorited(): bool
    {
        return (bool)$this->favorites->where('user_id', auth()->id())->count();
    }

    public function getFavoritesCount(): int
    {
        return count($this->favorites);
    }
}
