<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use App\Models\ActivityLog;

class LogUserLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UserLoggedIn $event)
    {
        ActivityLog::create([
            'user_id' => $event->user->id,
            'activity' => 'Login',
            'description' => $event->user->name.' logged in',
            'ip_address' => request()->ip(),
        ]);
    }
}
