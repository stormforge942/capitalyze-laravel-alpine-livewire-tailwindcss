<?php

namespace App\Http\Livewire\AccountSettings;

use Illuminate\Support\Facades\Hash;
use WireElements\Pro\Components\Modal\Modal;

class ConfirmRevokeDevice extends Modal
{
    public $platform;
    public $sessionId;

    public function cancelRevocation()
    {
        $this->close();
    }

    public function render()
    {
        return view('livewire.account-settings.confirm-revoke-device');
    }
}
