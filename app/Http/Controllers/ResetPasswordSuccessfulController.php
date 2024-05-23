<?php

namespace App\Http\Controllers;

use App\Models\User;

class ResetPasswordSuccessfulController extends Controller
{
    public function __invoke()
    {
        if (!session()->has('isValid') || !session()->has('user')) {
            return redirect()->route('login');
        }

        $user = User::find((int)session()->get('user'));
        $user->is_password_set = true;
        $user->save();

        return view('auth.reset-password-successful', [
            'flow' => request('flow'),
            'user' => $user
        ]);
    }
}
