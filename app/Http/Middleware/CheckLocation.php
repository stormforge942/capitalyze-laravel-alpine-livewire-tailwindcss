<?php

namespace App\Http\Middleware;

use Closure;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class CheckLocation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    private function getIpLocation($ip)
    {
        $response = Http::withToken(config('services.ipinfo.key'))->get('https://ipinfo.io/'.$ip.'/json');

        if ($response->successful()) {
            $locationData = $response->json();
            $ip_location = $locationData['city'].', '.$locationData['country'];
        } else {
            $ip_location = 'unknown';
        }

        return $ip_location;
    }

    private function storeSessionRedis($request)
    {
        $sessionId = session()->getId();
        $user = Auth::user();

        if ($sessionId && $user) {
            $sessionKey = "session_{$user->id}_{$sessionId}";
            $sessionData = Redis::get($sessionKey);

            // Decode session data from Redis if it exists
            $sessionData = $sessionData ? json_decode($sessionData, true) : null;

            // If session does not exist or 'ip_location' is missing, fetch and store location
            if (!$sessionData || !isset($sessionData['ip_location'])) {
                $agent = new Agent();
                $devicePlatform = $agent->platform();
                $deviceBrowser = $agent->browser();
                $ipAddress = $request->ip();

                if ($ipAddress === '127.0.0.1' || $ipAddress === '::1') {
                    // Set a default location for localhost
                    $ip_location = 'Localhost';
                } else {
                    // Fetch the location if it's not localhost
                    $ip_location = $this->getIpLocation($ipAddress);
                }

                // Update or create the session in Redis with the new data
                $sessionData = [
                    'id' => $sessionId,
                    'user_id' => $user->id,
                    'platform' => $devicePlatform,
                    'browser' => $deviceBrowser,
                    'ip_address' => $ipAddress,
                    'last_activity' => time(),
                    'ip_location' => $ip_location,
                ];

                // Store the updated session data in Redis
                Redis::set($sessionKey, json_encode($sessionData));
            }
        }
    }

    private function storeSessionDatabase($request)
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
                $ip_location = $this->getIpLocation($ip);
            }

            // Update the session with location data
            DB::table('sessions')
                ->where('id', $sessionId)
                ->update(['ip_location' => $ip_location]);
        }
    }

    public function handle(Request $request, Closure $next)
    {
        $sessionDriver = config('session.driver');

        if ($sessionDriver == 'database') {
            $this->storeSessionDatabase($request);
        } else if ($sessionDriver == 'redis') {
            $this->storeSessionRedis($request);
        }

        return $next($request);
    }
}
