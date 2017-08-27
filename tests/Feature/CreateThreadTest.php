<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestResponse;
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

        $this->withExceptionHandling()
            ->get('/threads/create')
            ->assertRedirect('/login');
    }

    /**
     * @test
     */
    public function an_authenticated_user_can_crate_an_new_thread()
    {
        $this->signIn();

        $thread = make(Thread::class);

        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function unauthenticated_user_can_not_delete_a_thread()
    {
        $this->withExceptionHandling();
        $thread = create(Thread::class);

        $this->delete($thread->path())->assertRedirect('/login');

        $this->signIn();
        $this->delete($thread->path())->assertStatus(403);
    }

    /** @test */
    public function authorised_user_can_delete_a_thread()
    {
        $this->signIn();

        $thread = create(Thread::class, ['user_id' => auth()->id()]);
        $reply = create(Reply::class, ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id])
            ->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    /**
     * @test
     */
    public function a_thread_requires_a_title()
    {
        $this->withExceptionHandling()->signIn();

        $this->_publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /**
     * @test
     */
    public function a_thread_requires_a_valid_channel()
    {
        $this->withExceptionHandling()->signIn();

        $this->_publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->_publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    /**
     * @test
     */
    public function a_thread_requires_a_body()
    {
        $this->withExceptionHandling()->signIn();

        $this->_publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    private function _publishThread(array $overrides): TestResponse
    {
        return $this->post('/threads', make(Thread::class, $overrides)->toArray());
    }
}
