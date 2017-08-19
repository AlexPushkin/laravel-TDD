<?php

namespace App\Filters;

use App\User;

class ThreadFilters extends Filters
{
    protected $_filters = ['by'];

    protected function by(string $username)
    {
        $user = User::where('name', $username)->firstOrFail();

        $this->_builder->where('user_id', $user->id);
    }
}