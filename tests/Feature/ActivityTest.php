<?php

namespace Tests\Feature;

use App\Activity;
use App\Reply;
use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_records_an_activity_when_a_thread_is_created()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $this->assertDatabaseHas('activities', [
            'subject_id'   => $thread->id,
            'subject_type' => Thread::class,
            'user_id'      => auth()->id(),
            'type'         => 'created_thread',
        ]);

        $activity = Activity::first();

        $this->assertEquals($thread->id, $activity->subject->id);
    }

    /** @test */
    public function it_records_an_activity_when_reply_is_created()
    {
        $this->signIn();

        $reply = create(Reply::class);

        $this->assertEquals(2, Activity::count());

        $this->assertDatabaseHas('activities', [
            'subject_id'   => $reply->id,
            'subject_type' => Reply::class,
            'user_id'      => auth()->id(),
            'type'         => 'created_reply',
        ]);
    }
}