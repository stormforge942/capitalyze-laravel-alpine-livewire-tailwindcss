<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Http\Responses\SuccessfulPasswordResetLinkRequestResponse;

class CustomSuccessfulPasswordResetLinkRequestResponse extends SuccessfulPasswordResetLinkRequestResponse
{
    public function toResponse($request)
    {
        return $request->wantsJson()
            ? new JsonResponse(['message' => trans($this->status)], 200)
            : redirect()->route('password.reset-link.sent')->with('isValid', true);
    }
}
