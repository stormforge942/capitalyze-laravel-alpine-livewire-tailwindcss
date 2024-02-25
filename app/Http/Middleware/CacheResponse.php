<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;

class CacheResponse
{
    public function handle($request, Closure $next, $ttl = 60)
    {
        $key = 'route_' . md5($request->url());
        if (Cache::has($key)) {
            return response(Cache::get($key));
        }

        $response = $next($request);

        // Cache the response
        Cache::put($key, $response->getContent(), now()->addMinutes($ttl));

        return $response;
    }
}
