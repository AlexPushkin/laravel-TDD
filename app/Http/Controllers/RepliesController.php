<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Thread;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function add(Channel $channel, Thread $thread)
    {
        $thread->addReply([
            'body'    => request('body'),
            'user_id' => auth()->id(),
        ]);

        return redirect($thread->path());
    }
}
