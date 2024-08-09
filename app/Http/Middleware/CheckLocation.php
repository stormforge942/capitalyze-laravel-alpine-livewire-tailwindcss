<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CheckLocation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $sessionId = session()->getId();
        $session = DB::table('sessions')->where('id', $sessionId)->first();

        if ($session && is_null($session->ip_location)) {
            $ip = $request->ip();

            if ($ip === '127.0.0.1' || $ip === '::1') {
                // Set a default location for localhost
                $ip_location = 'Localhost';
            } else {
                // Fetch location data from IPinfo
                $response = Http::withToken(config('services.ipinfo.key'))->get('https://ipinfo.io/'.$ip.'/json');

                if ($response->successful()) {
                    $locationData = $response->json();
                    $ip_location = $locationData['city'].', '.$locationData['country'];
                } else {
                    $ip_location = 'unknown';
                }
            }

            // Update the session with location data
            DB::table('sessions')
                ->where('id', $sessionId)
                ->update(['ip_location' => $ip_location]);
        }

        return $next($request);
    }
}
