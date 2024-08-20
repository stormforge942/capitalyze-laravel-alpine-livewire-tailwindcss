<?php

namespace App\Http\Livewire\Ownership;

use App\Http\Livewire\Ownership\CompanyInsiders;
use App\Models\Company;
use App\Models\CompanyInsider;
use App\Services\OwnershipHistoryService;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class Page extends Component
{
    public Company $company;
    public $formTypes;

    public array $tabs;

    public function mount(Company $company)
    {
        $this->company = $company;

        $this->tabs = [
            Shareholders::class,
            MutualFunds::class,
            [CompanyInsiders::class, $company->ticker . ' Insider Transactions'],
            InsiderOwnership::class,
            ProxyStatement::class,
            FundsSummary::class,
        ];

        OwnershipHistoryService::push([
            'name' => $this->company->name,
            'url' => request()->url(),
        ]);

        $this->formTypes = [
            'shareholders' => '13F',
            'mutual-funds' => 'NPORT-P',
            'company-insiders' => implode(',', $this->insiderFormTypes()),
        ];
    }

    public function insiderFormTypes()
    {
        $cacheKey = 'insider_form_types_' . $this->company->ticker;

        $cacheDuration = 3600;

        $formTypes = Cache::remember($cacheKey, $cacheDuration, function () {
            return CompanyInsider::query()
                ->where('symbol', $this->company->ticker)
                ->distinct()
                ->pluck('form_type')
                ->toArray();
        });

        return $formTypes;
    }

    public function render()
    {
        return view('livewire.ownership.page');
    }
}
