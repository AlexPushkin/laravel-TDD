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

        @if (auth()->check())
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <form method="POST" action="{{ $thread->path() . '/replies' }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <textarea name="body" id="body" rows="5" class="form-control" placeholder="Have something to say?"></textarea>
                        </div>
                        <button type="submit" class="btn btn-default">submit</button>

                    </form>
                </div>
            </div>
        @endif
    </div>
@endsection
