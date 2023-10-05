<?php

namespace App\Http\Controllers;

class ResetLinkSentController extends Controller
{
    public function __invoke()
    {
        if (!session()->has('isValid')) {
            return redirect()->route('password.request');
        }

        return view('auth.reset-link-sent');
    }
}
