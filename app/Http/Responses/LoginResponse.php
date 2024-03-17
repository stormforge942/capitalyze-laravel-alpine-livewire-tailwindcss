<?php

namespace App\Http\Responses;

use App\Models\Company;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;

class LoginResponse implements LoginResponseContract
{
    /**
     * @param  $request
     * @return mixed
     */
    public function toResponse($request)
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail() && $user->is_approved) {
            // Redirect to the appropriate page for an approved and verified user
            // Customize the redirection logic based on your requirements
            if ($user->is_admin) {
                return redirect()->intended('/admin/users');
            } else {
                return redirect()->route('company.profile', Company::DEFAULT_TICKER);
            }
        } else {
            // Redirect to the waiting-for-approval page for users who haven't been approved or verified
            return redirect()->route('waiting-for-approval');
        }
    }
}
