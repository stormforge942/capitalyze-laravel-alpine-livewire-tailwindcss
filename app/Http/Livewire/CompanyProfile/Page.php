<?php

namespace App\Http\Livewire\CompanyProfile;

use Livewire\Component;

class Page extends Component
{
    public $company;
    public $period;

    public function render()
    {
        return view('livewire.company-profile.page', [
            'tabs' => [
                CompanyOverview::class,
                BusinessInformation::class,
            ],
            'tabData' => [
                'profile' => \App\Models\CompanyProfile::query()
                    ->where('symbol', $this->company->ticker)
                    ->firstOrFail()
                    ->toArray(),
                'period' => $this->period,
            ],
        ]);
    }
}
