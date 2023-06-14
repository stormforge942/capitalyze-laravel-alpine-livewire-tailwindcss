<?php

namespace App\Http\Responses;

use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class CustomRegisterResponse implements RegisterResponseContract
{
    /**
     * @param  Request  $request
     * @return mixed
     */
    public function toResponse($request)
    {
        // You can redirect to a custom route here
        return redirect('/waiting-for-approval');
    }
}
