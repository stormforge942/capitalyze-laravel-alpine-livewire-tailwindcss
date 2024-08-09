<?php

namespace App\Http\Controllers;

use App\Models\PendingInvitation;
use App\Models\User;

class TeamInvitationController extends Controller
{
    public function __invoke(PendingInvitation $invitation)
    {
        $invitation->load('team', 'role');

        abort_if(! $invitation->team || ! $invitation->role, 404);

        return view('team-invitation', [
            'invitation' => $invitation,
            'isExistingUser' => User::where('email', $invitation->email)->exists(),
        ]);
    }
}
