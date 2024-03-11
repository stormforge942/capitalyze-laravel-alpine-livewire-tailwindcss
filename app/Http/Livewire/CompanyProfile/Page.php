<?php

namespace App\Http\Livewire\CompanyProfile;
use Illuminate\Support\Facades\Cache;

use Livewire\Component;

class Page extends Component
{
    public $company;
    public $period;

    public function render()
    {
        $companyProfileCacheKey = 'company_profile_' . $this->company->ticker;

        $cacheDuration = 3600;

        $companyProfile = Cache::remember($companyProfileCacheKey, $cacheDuration, function () {
            return \App\Models\CompanyProfile::query()
                ->where('symbol', $this->company->ticker)
                ->firstOrFail()
                ->toArray();
        });

        return view('livewire.company-profile.page', [
            'tabs' => [
                CompanyOverview::class,
                BusinessInformation::class,
            ],
            'tabData' => [
                'profile' => $companyProfile,
                'period' => $this->period,
            ],
        ]);
    }
}
