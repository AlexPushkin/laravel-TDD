<?php

namespace App\Filters;

use App\User;

class ThreadFilters extends Filters
{
    protected $_filters = ['by', 'popularity'];

    protected function by(string $username)
    {
        $user = User::where('name', $username)->firstOrFail();

        $this->_builder->where('user_id', $user->id);
    }

    protected function popularity()
    {
        $this->_builder->getQuery()->orders = [];
        $this->_builder->orderBy('replies_count', 'DESC');
    }
}