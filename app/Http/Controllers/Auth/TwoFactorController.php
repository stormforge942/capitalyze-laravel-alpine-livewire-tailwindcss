<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserLoggedIn;
use App\Http\Controllers\Controller;
use App\Mail\TwoFactorCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TwoFactorController extends Controller
{
    public function index()
    {
        return view('auth.two-factor');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|numeric',
        ]);

        $user = User::find($request->session()->get('user_id'));

        if ($user && $request->code == $user->two_factor_code && now()->lt($user->two_factor_expires_at)) {
            $user->resetTwoFactorCode();
            Auth::login($user);
            event(new UserLoggedIn($user));
            $request->session()->forget('user_id');

            return redirect()->route('home');
        }

        return redirect()->route('2fa.index')->withErrors(['code' => 'The provided two-factor code is incorrect or expired.']);
    }

    public function resend(Request $request)
    {
        $user = User::find($request->session()->get('user_id'));

        if ($user) {
            $this->send2FACode($user);

            return redirect()->route('2fa.index')->with('status', 'A new two-factor code has been sent to your email.');
        }

        return redirect()->route('login')->withErrors(['email' => 'Unable to send new two-factor code. Please try logging in again.']);
    }

    protected function send2FACode($user)
    {
        $code = rand(100000, 999999);
        $user->two_factor_code = $code;
        $user->two_factor_expires_at = now()->addMinutes(10);
        $user->save();

        Mail::to($user->email)->send(new TwoFactorCode($code));
    }
}
