@extends('layouts.app')
<?php /** @var \App\Thread[] $threads */ ?>

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Forum threads</div>

                    <div class="panel-body">
                        @foreach ($threads as $thread)
                            <article>
                                <h4>
                                    <a href="{{ $thread->creator->pathToProfile() }}">{{ $thread->creator->name }}</a>
                                    posted
                                    <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                                    {{ $thread->created_at->diffForHumans() }}
                                </h4>
                                <div class="body">{{ $thread->body }}</div>
                            </article>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection