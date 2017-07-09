<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Thread extends Model
{
    public function path(): string
    {
        return '/threads/' . $this->id;
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class, 'thread_id', 'id');
    }

    public function creator(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
