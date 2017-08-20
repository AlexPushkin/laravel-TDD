<?php

namespace App;

use App\Filters\ThreadFilters;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Thread extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function ($builder) {
            $builder->withCount('replies');
        });
    }

    public static function scopeFilter($scope, ThreadFilters $filters)
    {
        return $filters->apply($scope);
    }

    public function path(): string
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class, 'thread_id', 'id');
    }

    public function creator(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class, 'channel_id', 'id');
    }

    public function addReply(array $array)
    {
        $this->replies()->create($array);
    }
}
