<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RemoveSession
{
    public function handle($request, Closure $next)
    {
        $sessionId = session()->getId();

        try {
            DB::table('sessions')->where('id', $sessionId)->delete();
        } catch (\Exception $e) {
            Log::error('Error removing session: ' . $e->getMessage());
        }

        return $next($request);
    }
}
