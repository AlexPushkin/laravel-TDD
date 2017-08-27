@extends('layouts.app')
<?php
/**
 * @var \App\User     $profileUser
 * @var \App\Thread[] $threads
 */
?>
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="page-header">
                    <h1>
                        {{ $profileUser->name }}
                        <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
                    </h1>
                </div>

                @foreach($activities as $period => $group)
                    <h3 class="page-header">{{ $period }}</h3>
                    @foreach($group as $activity)
                        @include("profiles.activities.{$activity->type}")
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
@endsection
