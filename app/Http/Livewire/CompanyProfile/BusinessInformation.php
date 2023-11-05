<?php

namespace App\Http\Livewire\CompanyProfile;

use App\Http\Livewire\AsTab;
use Livewire\Component;

class BusinessInformation extends Component
{
    use AsTab;

    public $profile;

    public function mount(array $data = [])
    {
        $this->profile = $data['profile'];
    }

    public function render()
    {
        return view('livewire.company-profile.business-information');
    }
}
