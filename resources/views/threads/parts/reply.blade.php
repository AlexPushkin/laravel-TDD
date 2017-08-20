<?php
/** @var \App\Reply $reply */
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="level">
            <h5 class="flex">
                <a href="{{ $reply->owner->pathToProfile() }}">
                    {{ $reply->owner->name }}
                </a>
                said {{ $reply->created_at->diffForHumans() }}
            </h5>


            <form action="/replies/{{ $reply->id }}/favorites" method="POST">
                {{ csrf_field() }}
                <button class="btn btn-default" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                    {{ $reply->favorites()->count() }} {{ str_plural('like', $reply->favorites()->count()) }}
                </button>
            </form>
        </div>

    </div>

    <div class="panel-body">
        {{ $reply->body }}
    </div>
</div>