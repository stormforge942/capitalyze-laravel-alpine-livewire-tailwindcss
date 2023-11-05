<?php

namespace App\Http\Livewire\CompanyProfile;

use Livewire\Component;
use App\Http\Livewire\AsTab;
use App\Models\CompanyPresentation;

class BusinessInformation extends Component
{
    use AsTab;

    public $menuLinks;

    public function mount($data = [])
    {
        $ticker = $data['profile']['symbol'];

        $this->menuLinks = CompanyPresentation::query()
            ->where('business', '!=', null)
            ->where('symbol', $ticker)
            ->orderByDesc('acceptance_time')
            ->first()
            ?->toArray();
    }

    public function render()
    {
        return view('livewire.company-profile.business-information');
    }
}
