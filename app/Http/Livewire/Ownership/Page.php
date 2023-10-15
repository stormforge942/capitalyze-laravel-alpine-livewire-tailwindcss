<?php

namespace App\Http\Livewire\Ownership;

use App\Models\Company;
use Livewire\Component;

class Page extends Component 
{
    public Company $company;

    public array $tabs = [
        Shareholders::class,
        CompanyInsiders::class,
    ];

    public function mount(Company $company)
    {
        $this->company = $company;
    }

    public function render()
    {
        return view('livewire.ownership.page');
    }
}
