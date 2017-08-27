@extends('layouts.app')

<?php /** @var \App\Thread $thread */?>

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="level">
                            <span class="flex">
                                <a href="{{ $thread->creator->pathToProfile() }}">{{ $thread->creator->name }}</a>
                                posted:
                                {{ $thread->title }}
                            </span>

                            @can('update', $thread)
                                <form action="{{ $thread->path() }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <button class="btn btn-link">
                                        Delete thread
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>

                    <div class="panel-body">
                        {{ $thread->body }}
                    </div>
                </div>

                @foreach($replies as $reply)
                    @include('threads.parts.reply')
                @endforeach

                {{ $replies->links() }}

                @if (auth()->check())
                    <form method="POST" action="{{ $thread->path() . '/replies' }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <textarea name="body" id="body" rows="5" class="form-control"
                                      placeholder="Have something to say?"></textarea>
                        </div>
                        <button type="submit" class="btn btn-default">submit</button>

                    </form>
                @endif
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>
                            This thread was published {{ $thread->created_at->diffForHumans() }} by
                            <a href="{{ $thread->creator->pathToProfile() }}">{{ $thread->creator->name }}</a>,
                            and currently
                            has {{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count) }}.
                        </h4>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
