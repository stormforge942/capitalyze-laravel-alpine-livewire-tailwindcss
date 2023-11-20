<?php

namespace App\Http\Livewire\Ownership;

use App\Models\Company;
use Livewire\Component;
use App\Models\CompanyInsider;
use App\Services\OwnershipHistoryService;

class Page extends Component
{
    public Company $company;
    public $formTypes;

    public array $tabs = [
        Shareholders::class,
        CompanyInsidersTable::class,
    ];

    public function mount(Company $company)
    {
        $this->company = $company;

        OwnershipHistoryService::push([
            'name' => $this->company->name,
            'url' => request()->url(),
        ]);

        $this->formTypes = $this->getFormTypes();
    }

    public function getFormTypes()
    {
        return CompanyInsider::query()
            ->where('symbol', $this->company->ticker)
            ->distinct()
            ->pluck('form_type')
            ->toArray();
    }

    public function render()
    {
        return view('livewire.ownership.page');
    }
}
