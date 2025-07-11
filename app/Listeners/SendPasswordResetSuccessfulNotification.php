<?php

namespace App\Listeners;

use Illuminate\Auth\Events\PasswordReset;
use App\Notifications\PasswordResetSuccessfulNotification;

class SendPasswordResetSuccessfulNotification
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\PasswordReset  $event
     * @return void
     */
    public function handle(PasswordReset $event)
    {
        if (request('flow') !== 'create-password') {
            $event->user->notify(new PasswordResetSuccessfulNotification);
        }
    }
}
