<?php

namespace App\Http\Controllers;

use App\Activity;
use App\User;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $activities = $user->activities()->latest()->with('subject')->take(30)->get()->groupBy(function (Activity $activity) {
            return $activity->created_at->format('Y-m-d');
        });

        return view('profiles.show', [
            'profileUser' => $user,
            'activities'  => $activities,
        ]);
    }
}