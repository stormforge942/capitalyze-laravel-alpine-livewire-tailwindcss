<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserLoggedIn;
use App\Mail\TwoFactorCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Requests\LoginRequest;

class CustomAuthenticatedSessionController extends AuthenticatedSessionController
{
    public function store(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->isTwoFactorEnabled()) {
                Auth::logout();
                $request->session()->put('user_id', $user->id);
                $this->send2FACode($user);

                return redirect()->route('2fa.index');
            }

            event(new UserLoggedIn($user));

            return redirect()->route('company.profile', 'AAPL');
        }

        return redirect()->back()->withErrors(['email' => 'The provided credentials are incorrect.']);
    }

    protected function send2FACode($user)
    {
        $code = rand(100000, 999999);
        $user->two_factor_code = $code;
        $user->two_factor_expires_at = now()->addMinutes(10);
        $user->save();

        Mail::to($user->two_factor_email)->send(new TwoFactorCode($code));
    }
}
