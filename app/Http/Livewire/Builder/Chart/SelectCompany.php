<?php

namespace App\Http\Livewire\Builder\Chart;

use App\Models\Company;
use Livewire\Component;

class SelectCompany extends Component
{
    public $search = '';
    public $selected = [];

    public function render()
    {
        return view('livewire.builder.chart.select-company', [
            'companies' => $this->getCompanies($this->selected),
        ]);
    }

    public function getCompanies(array $_selectedCompanies = [])
    {
        $term = "%$this->search%";

        $_selectedCompanies = array_map(fn ($company) => strtoupper($company), $_selectedCompanies);

        $selectedCompanies = Company::query()
            ->whereIn('ticker', $_selectedCompanies)
            ->get()
            ->toArray();

        return [
            ...$selectedCompanies,
            ...Company::query()
                ->when(
                    $this->search,
                    fn ($q) =>  $q->where('name', 'ilike', $term)
                        ->orWhere('ticker', 'ilike', strtoupper($term))
                )
                ->whereNotIn('ticker', $_selectedCompanies)
                ->limit(6)
                ->get()
                ->toArray()
        ];
    }
}
