<?php

namespace App\Http\Livewire\AccountSettings;

use App\Http\Livewire\AsTab;
use App\Models\ActivityLog;
use App\Models\User;
use Livewire\Component;

class Security extends Component
{
    use AsTab;

    public $logs;

    public $columns = [[
        'name' => 'Name',
    ], [
        'name' => 'Activity',
    ], [
        'name' => 'Description',
    ]];

    public function mount()
    {
        $teamMemberIds = User::where('current_team_id', 1)->pluck('id');

        $this->logs = ActivityLog::whereIn('user_id', $teamMemberIds)
            ->where('activity', 'Login')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.account-settings.security');
    }
}
