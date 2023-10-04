<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Http\Responses\PasswordResetResponse;

class CustomPasswordResetResponse extends PasswordResetResponse
{
    public function toResponse($request)
    {
        return $request->wantsJson()
            ? new JsonResponse(['message' => trans($this->status)], 200)
            : redirect()->route('password.reset.successful')->with('isValid', true);
    }
}
