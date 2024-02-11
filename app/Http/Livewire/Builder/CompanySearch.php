<?php

namespace App\Http\Livewire\Builder;

use App\Models\Company;
use Livewire\Component;

class CompanySearch extends Component
{
    public $search = '';
    public $companies = [];

    protected $queryString = [
        'search' => ['except' => '']
    ];

    public function render()
    {
        $this->getCompanies();

        return view('livewire.builder.company-search', [
            'companies' => $this->getCompanies($this->search),
        ]);
    }

    public function getCompanies()
    {
        $term = "%$this->search%";

        $this->companies = Company::query()
            ->when(
                $this->search,
                fn ($q) => $q->where('name', 'ilike', $term)
                    ->orWhere('ticker', 'ilike', $term)
            )
            ->orderBy('name')
            ->limit(10)
            ->pluck('name', 'cik');
    }
}
