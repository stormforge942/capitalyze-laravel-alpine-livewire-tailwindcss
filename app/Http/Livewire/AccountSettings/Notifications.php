<?php

namespace App\Http\Livewire\AccountSettings;

use App\Http\Livewire\AsTab;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Notifications extends Component
{
    use AsTab;

    public $settings;

    public $columns = [
        'receive_email' => [
            'text' => 'Receive email notifications',
            'type' => 'Enterprise',
        ],
        'account_activity' => [
            'text' => 'Account activity notifications',
            'type' => 'Enterprise',
        ],
        'marketing_emails' => [
            'text' => 'Marketing emails',
            'type' => 'Enterprise',
        ],
        'new_feature_launch' => [
            'text' => 'New Feature Launch',
            'type' => 'Enterprise',
        ],
        'team_member_action' => [
            'text' => 'Team Member\'s action',
            'type' => 'Enterprise',
        ],
        'new_user' => [
            'text' => 'New User',
            'type' => 'Enterprise',
        ],
        'stock_price_alert' => [
            'text' => 'Stock Price Alert',
            'type' => 'Enterprise',
        ],
        'latest_filings_upload' => [
            'text' => 'Latest Filings uploads',
            'type' => 'Enterprise',
        ],
    ];

    public function mount()
    {
        $settings = Auth::user()->settings;

        if ($settings && isset($settings['notifications'])) {
            $this->settings = $settings['notifications'];
        } else {
            $this->settings = [];
        }
    }

    public function updateSetting($key, $value)
    {
        $this->settings[$key] = $value;
        $this->saveSettings();
    }

    public function saveSettings()
    {
        $user = Auth::user();
        $settings = $user->settings;

        if (! is_array($settings)) {
            $settings = [];
        }

        $settings['notifications'] = $this->settings;

        $user->settings = $settings;
        $user->save();
    }

    public function render()
    {
        return view('livewire.account-settings.notifications', [
            'columns' => $this->columns,
            'settings' => $this->settings,
        ]);
    }
}
