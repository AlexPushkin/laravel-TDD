@extends('layouts.app')

<?php /** @var \App\Thread $thread */?>

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>
                            <a href="{{ $thread->creator->pathToProfile() }}">{{ $thread->creator->name }}</a>
                            posted:
                            {{ $thread->title }}
                            {{ $thread->created_at->diffForHumans() }}
                        </h4></div>

                    <div class="panel-body">
                        {{ $thread->body }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @foreach($thread->replies as $reply)
                   @include('threads.parts.reply')
                @endforeach
            </div>
        </div>

    </div>
@endsection
