<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReadThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @var  Thread */
    private $_thread;

    public function setUp()
    {
        parent::setUp();

        $this->_thread = create(Thread::class);
    }

    /** @test */
    public function a_user_can_browse_threads()
    {
        $this->get('/threads')->assertSee($this->_thread->title);
    }

    /** @test */
    public function a_user_can_browse_a_single_thread()
    {
        $this->get($this->_thread->path())->assertSee($this->_thread->title);
    }

    /** @test */
    public function a_user_can_read_a_reply()
    {
        $reply = create(Reply::class, ['thread_id' => $this->_thread->id]);

        $this->get($this->_thread->path())->assertSee($reply->body);
    }

    /** @test */
    public function a_user_cant_filter_threads_by_username()
    {
        $this->signIn(create(User::class, ['name' => 'AlexPushkin']));

        $threadByPushkin = create(Thread::class, ['user_id' => auth()->id()]);

        $threadNotByPushkin = create(Thread::class);

        $this->get('/threads?by=AlexPushkin')
            ->assertSee($threadByPushkin->title)
            ->assertDontSee($threadNotByPushkin->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_popularity()
    {
        $threadWithThreeReplies = create(Thread::class);
        create(Reply::class, ['thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithTwoReplies = create(Thread::class);
        create(Reply::class, ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithNoReplies = $this->_thread;

        $response = $this->getJson('threads?popularity=1')->json();

        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
    }
}
