@extends('layouts.app')
<?php /** @var \App\Thread[] $threads */ ;?>


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @forelse($threads as $thread)

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="level">
                                <h4 class="flex">
                                    <a href="{{ $thread->creator->pathToProfile() }}">{{ $thread->creator->name }}</a>
                                    posted
                                    <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                                    {{ $thread->created_at->diffForHumans() }}
                                </h4>

                                <a href="{{ $thread->path() }}">
                                    {{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count) }}
                                </a>
                            </div>
                        </div>

                        <div class="panel-body">
                            <article>
                                <div class="body">{{ $thread->body }}</div>
                            </article>
                        </div>
                    </div>
                @empty
                    <p>There are no relevant threads on this channel</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
