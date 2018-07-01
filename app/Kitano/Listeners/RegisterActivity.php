<?php

namespace App\Kitano\Listeners;

use App\Activity;
use App\Kitano\Events\NewActivity;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegisterActivity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param NewActivity $event
     * @return void
     */
    public function handle(NewActivity $event)
    {
        $data = [
            'user_id' => $event->user,
            'op' => $event->op,
            'old' => $event->old,
            'new' => $event->new,
        ];

        Activity::create($data);
    }
}