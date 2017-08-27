<?php

namespace App;


trait RecordsActivity
{
    protected static function bootRecordsActivity()
    {
        if (auth()->guest()) {
            return;
        }

        foreach (self::getActivitiesToRecord() as $recordEvent) {
            static::$recordEvent(function ($thread) use ($recordEvent) {
                $thread->recordActivity($recordEvent);
            });
        }
    }

    protected static function getActivitiesToRecord():array
    {

        return isset(self::$recordEvents) ? self::$recordEvents : ['created'];
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    protected function recordActivity(string $event)
    {
        $this->activity()->create([
                'user_id' => auth()->id(),
                'type'    => $this->getActivityType($event),
            ]
        );
    }

    protected function getActivityType(string $event): string
    {
        $shortClass = strtolower((new \ReflectionClass($this))->getShortName());

        return "{$event}_{$shortClass}";
    }
}