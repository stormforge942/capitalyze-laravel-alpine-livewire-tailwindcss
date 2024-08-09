<?php

namespace App\Http\Livewire\AccountSettings;

use App\Http\Livewire\AsTab;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SecurityMine extends Component
{
    use AsTab;

    public $isDeviceShow = false;

    public $sessions = [];

    public $tfa_enabled = false;

    protected $listeners = ['2fa-updated' => 'fetch2FAStatus'];

    public function mount()
    {
        $this->fetchSessions();
        $this->fetch2FAStatus();
    }

    public function fetch2FAStatus()
    {
        $this->tfa_enabled = Auth::user()->isTwoFactorEnabled();
    }

    public function fetchSessions()
    {
        $this->sessions = DB::table('sessions')
            ->where('user_id', Auth::id())
            ->get()
            ->map(function ($session) {
                return [
                    'id' => $session->id,
                    'ip_location' => $session->ip_location,
                    'ip_address' => $session->ip_address,
                    'is_current_device' => $session->id === session()->getId(),
                    'agent' => [
                        'platform' => $this->platform($session->user_agent),
                        'browser' => $this->browser($session->user_agent),
                    ],
                    'last_active' => $this->formatTimestamp($session->last_activity),
                ];
            })
            ->toArray();
    }

    public function formatTimestamp($timestamp)
    {
        $date = Carbon::createFromTimestamp($timestamp);
        $now = Carbon::now();

        if ($date->isToday()) {
            return 'Today at '.$date->format('g:ia');
        } elseif ($date->isYesterday()) {
            return 'Yesterday at '.$date->format('g:ia');
        } else {
            return $date->format('F j, Y \a\t g:ia');
        }
    }

    public function platform($userAgent)
    {
        // Extract the platform from the user agent string (simplified)
        if (str_contains($userAgent, 'Windows')) {
            return 'Windows';
        } elseif (str_contains($userAgent, 'Macintosh')) {
            return 'Macintosh';
        } elseif (str_contains($userAgent, 'Linux')) {
            return 'Linux';
        } else {
            return 'Unknown';
        }
    }

    public function browser($userAgent)
    {
        // Extract the browser from the user agent string (simplified)
        if (str_contains($userAgent, 'Chrome')) {
            return 'Chrome';
        } elseif (str_contains($userAgent, 'Firefox')) {
            return 'Firefox';
        } elseif (str_contains($userAgent, 'Safari')) {
            return 'Safari';
        } else {
            return 'Unknown';
        }
    }

    public function revokeDevice($sessionId)
    {
        DB::table('sessions')->where('id', $sessionId)->delete();
        $this->fetchSessions();
    }

    public function getPasswordConfirmedProperty()
    {
        $period = config('auth.password_timeout', 900);

        return (time() - session('auth.password_confirmed_at', 0)) < $period;
    }

    public function disableTwoFactorAuthentication()
    {
        $user = Auth::user();
        $user->two_factor_email = null;
        $user->two_factor_code = null;
        $user->two_factor_expires_at = null;
        $user->save();

        $this->fetch2FAStatus();
    }

    public function render()
    {
        return view('livewire.account-settings.security-mine');
    }
}
