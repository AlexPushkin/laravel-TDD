<?php

namespace Tests\Unit;

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

        $this->_thread = factory(Thread::class)->create();
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
}
