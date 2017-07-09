<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
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

        $this->_thread = factory(Thread::class)->create();
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
        $reply = factory(Reply::class)->create(['thread_id' => $this->_thread->id]);

        $this->get($this->_thread->path())->assertSee($reply->body);

    }
}
