<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function guest_cant_create_threads()
    {
        $this->expectException(AuthenticationException::class);
        $this->post('/threads');
    }

    /**
     * @test
     */
    public function an_authenticated_user_can_crate_an_new_thread()
    {
        $this->actingAs(factory(User::class)->create());

        $thread = factory(Thread::class)->make();

        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
