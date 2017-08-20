<?php

namespace App\Http\Controllers;

use App\Reply;

class FavoritesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Reply $reply)
    {
        return $reply->favorite(auth()->id());
    }
}