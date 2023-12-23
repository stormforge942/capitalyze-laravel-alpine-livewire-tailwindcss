<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __invoke()
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        if (!$user) {
            return view('waitlist');
        }

        if (!$user->is_approved || !$user->hasVerifiedEmail()) {
            return redirect()->route('waiting-for-approval');
        }

        return redirect()->route('company.profile', 'AAPL');
    }
}
