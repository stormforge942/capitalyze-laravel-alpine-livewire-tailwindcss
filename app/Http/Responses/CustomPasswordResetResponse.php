<?php

namespace App\Http\Responses;

use Laravel\Fortify\Http\Responses\PasswordResetResponse;

class CustomPasswordResetResponse extends PasswordResetResponse
{
    public function toResponse($request)
    {
        return redirect()->route('password.reset.successful')->with('isValid', true);
    }
}
