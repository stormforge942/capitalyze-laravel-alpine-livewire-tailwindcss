<?php

namespace App\Http\Livewire\AccountSettings;

use App\Enums\Plan;
use Illuminate\Http\Request;
use Livewire\Component;

class Page extends Component
{
    public string $tab;

    public string $subTab;

    private $tabs = [
        'admin' => [
            [
                'title' => 'company-information',
                'description' => 'Company Information',
                'component' => 'account-settings.company-information',
            ],
            [
                'title' => 'team-members',
                'description' => 'Team Members',
                'component' => 'account-settings.team-members',
            ],
            [
                'title' => 'roles',
                'description' => 'Roles',
                'component' => 'account-settings.roles',
            ],
            [
                'title' => 'security',
                'description' => 'Security',
                'component' => 'account-settings.security',
            ],
            [
                'title' => 'capitalyze-account',
                'description' => 'Capitalyze Account',
                'component' => 'account-settings.capitalyze-account',
            ],
        ],
        'mine' => [
            [
                'title' => 'profile-information',
                'description' => 'Profile Information',
                'component' => 'account-settings.profile-information',
            ],
            [
                'title' => 'data-settings',
                'description' => 'Data Settings',
                'component' => 'account-settings.data-settings',
            ],
            [
                'title' => 'notifications',
                'description' => 'Notifications',
                'component' => 'account-settings.notifications',
            ],
            [
                'title' => 'security-mine',
                'description' => 'Security',
                'component' => 'account-settings.security-mine',
            ],
        ],
    ];

    public function mount(Request $request)
    {
        $team = $request->user()->team;

        if ($team->plan !== Plan::COMPANY || $team->owner_id !== $request->user()->id) {
            unset($this->tabs['admin']);
        }

        $this->tab = in_array($request->query('tab'), array_keys($this->tabs))
            ? $request->query('tab')
            : array_keys($this->tabs)[0];

        $possibleSubTabs = array_map(fn ($item) => $item['title'], $this->tabs[$this->tab]);

        $this->subTab = in_array($request->query('subTab'), $possibleSubTabs)
            ? $request->query('subTab')
            : $possibleSubTabs[0];
    }

    public function render()
    {
        return view('livewire.account-settings.page', ['tabs' => $this->tabs]);
    }
}
