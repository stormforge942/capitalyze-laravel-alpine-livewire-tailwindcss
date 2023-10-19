<?php

namespace App\Http\Controllers;

class ResetPasswordSuccessfulController extends Controller
{
    public function __invoke()
    {
        if (!session()->has('isValid')) {
            return redirect()->route('login');
        }

        return view('auth.reset-password-successful',[
            'flow' => request('flow')
        ]);
    }
}
