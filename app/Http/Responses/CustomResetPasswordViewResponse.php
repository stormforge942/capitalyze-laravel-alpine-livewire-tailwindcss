<?php

namespace App\Http\Responses;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Contracts\ResetPasswordViewResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CustomResetPasswordViewResponse implements ResetPasswordViewResponse
{
    /**
     * @param  Request  $request
     * @return mixed
     */
    public function toResponse($request)
    {
        if ($request->get('email')) {
            $entry = DB::table('password_resets')->where('email', $request->get('email'))->first();

            if ($entry &&  Hash::check($request->route('token'), $entry->token)) {
                $createdAt = Carbon::parse($entry->created_at);
                if (!Carbon::now()->greaterThan($createdAt->addMinutes(config('auth.passwords.users.expire')))) {
                    return view('auth.reset-password', [
                        'request' => $request,
                        'flow' => $request->get('flow'),
                    ]);
                }
            }
        }

        throw new NotFoundHttpException;
    }
}
