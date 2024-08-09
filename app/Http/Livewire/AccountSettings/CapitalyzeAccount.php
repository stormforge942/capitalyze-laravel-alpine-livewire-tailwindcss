<?php

namespace App\Http\Livewire\AccountSettings;

use App\Http\Livewire\AsTab;
use Livewire\Component;

class CapitalyzeAccount extends Component
{
    use AsTab;

    public $menuLinks;

    public function mount($data = [])
    {

    }

    public function render()
    {
        return view('livewire.account-settings.capitalyze-account');
    }
}
