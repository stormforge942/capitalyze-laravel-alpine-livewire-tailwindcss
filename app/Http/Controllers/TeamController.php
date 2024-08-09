<?php

namespace App\Http\Controllers;

use App\Enums\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function checkMember(Request $request)
    {
        $team = Auth::user()->team;

        abort_if($team->owner_id != Auth::id(), 403);

        $email = $request->input('email');
        $user = User::where('email', $email)->first();

        $pendingInvitation = $team->invitations()->where('email', $email)->first();

        $msg = '';

        if ($user && $team->plan === Plan::COMPANY) {
            $msg = ($team->owner_id === $user->id || $team->members()->where('user_id', $user->id)->exists())
                ? 'Already a member of the team'
                : 'Already a member of another team';
        } elseif ($pendingInvitation) {
            $msg = 'Invitation already sent';
        }

        return response()->json(['msg' => $msg, 'email' => $email]);
    }
}
