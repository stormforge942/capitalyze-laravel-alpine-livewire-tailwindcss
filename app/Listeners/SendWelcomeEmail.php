<?php

namespace App\L\Listeners;

use Illuminate\Auth\Events\Registered;

class SendWelcomeEmail
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Verified  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $event->user->notify(new \App\Notifications\WaitlistWelcomeNotification);
    }
}
