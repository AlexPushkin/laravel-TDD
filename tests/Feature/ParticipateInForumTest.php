<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_unauthenticated_user_cant_add_an_reply()
    {
        $this->withExceptionHandling()
            ->post('/threads/php/1/replies')
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_participate_in_forum()
    {
        $this->be($user = create(User::class));

        $thread = create(Thread::class);

        $reply = make(Reply::class);

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())->assertSee($reply->body);
    }
}
