<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class CompanyProfile extends Component
{
    public $company;
    public $ticker;
    public $period;
    public $profile;

    public $infoTabActive = 'overview';

    public function setInfoActiveTab(string $tab): void {
        $this->infoTabActive = $tab;
        $this->emit('updateChart');
    }

    public $showFullProfile = false;
    public function toggleFullProfile(): void {
        $this->showFullProfile = !$this->showFullProfile;
    }

    public function mount($company, $ticker, $period)
    {
        $this->company  = $company;
        $this->ticker = $ticker;
        $this->period = $period;
        $this->getCompanyProfile();
    }

    public function getCompanyProfile() {
        $this->profile = \App\Models\CompanyProfile::query()
            ->where('symbol', $this->ticker)
            ->first()
            ?->toArray();
    }

    public function render()
    {
        return view('livewire.company-profile.component');
    }
}
