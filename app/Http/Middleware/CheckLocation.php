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

    public function handle(Request $request, Closure $next)
    {
        if (! Auth::check()) return $next($request);

        $sessionId = session()->getId();
        $session = DB::table('sessions')->where('id', $sessionId)->first();

        if ($session && is_null($session->ip_location)) {
            $ip = $request->ip();
            $lastActivity = now()->getTimestamp();
            $ip_location = ($ip === '127.0.0.1' || $ip === '::1') ? 'Localhost' : $this->getIpLocation($ip);

            DB::table('sessions')
                ->where('id', $sessionId)
                ->update([
                    'ip_location' => $ip_location,
                    'last_activity' => $lastActivity,
                ]);
        } else if (! $session) {
            $ip = $request->ip();
            $userAgent = $request->header('User-Agent');
            $payload = base64_encode(serialize(session()->all()));
            $lastActivity = now()->getTimestamp();
            $ip_location = ($ip === '127.0.0.1' || $ip === '::1') ? 'Localhost' : $this->getIpLocation($ip);

            DB::table('sessions')
                ->insert([
                    'id' => $sessionId,
                    'user_id' => $request->user()->id,
                    'ip_address' => $ip,
                    'user_agent' => $userAgent,
                    'payload' => $payload,
                    'last_activity' => $lastActivity,
                    'ip_location' => $ip_location,
                ]);
        } else {
            $lastActivity = now()->getTimestamp();

            DB::table('sessions')
                ->where('id', $sessionId)
                ->update([
                    'last_activity' => $lastActivity,
                ]);
        }

        return $next($request);
    }
}
