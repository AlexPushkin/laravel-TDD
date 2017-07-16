<?php

namespace Tests\Unit;

use App\Channel;
use App\Thread;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @var Thread */
    public $_thread;

    public function setUp()
    {
        parent::setUp();

        $this->_thread = create(Thread::class);
    }

    /** @test */
    public function a_thread_can_make_a_string_path()
    {
        $thread = create(Thread::class);

        $this->assertEquals("/threads/{$thread->channel->slug}/{$thread->id}", $thread->path());
    }

    /** @test */
    public function a_thread_have_replies()
    {
        $this->assertInstanceOf(Collection::class, $this->_thread->replies);
    }

    /** @test */
    public function a_thread_have_an_owner()
    {
        $this->assertInstanceOf(User::class, $this->_thread->creator);
    }

    /** @test */
    public function a_thread_can_add_an_reply()
    {
        $this->_thread->addReply([
            'body'    => 'Foobar',
            'user_id' => 1,
        ]);

        $this->assertCount(1, $this->_thread->replies);
    }

    /** @test */
    public function a_thread_belongs_to_a_channel()
    {
        $thread = make(Thread::class);

        $this->assertInstanceOf(Channel::class, $thread->channel);
    }
}
