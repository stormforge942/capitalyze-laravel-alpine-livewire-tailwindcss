<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Password;
use Laravel\Fortify\Contracts\VerifyEmailResponse;

class VerifyEmailController extends Controller
{
    public function __invoke(Request $request)
    {
        /** @var \App\Models\User */
        $user = User::find($request->route('id'));

        if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($user->hasVerifiedEmail()) {
            return app(VerifyEmailResponse::class);
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
            
            $user->notify(new \App\Notifications\WelcomeNotification);

            return redirect()->route('invited-auth.set-password', [
                'user' => $user->id,
                'token' => Password::createToken($user)
            ]);
        }

        return app(VerifyEmailResponse::class);
    }
}
