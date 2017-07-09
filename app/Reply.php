<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reply extends Model
{
    protected $guarded = [];

    public function owner(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}