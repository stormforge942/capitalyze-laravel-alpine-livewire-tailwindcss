<?php

namespace App\Http\Livewire\Builder;

use App\Models\Company;
use Livewire\Component;

class SelectCompany extends Component
{
    public $search = '';
    public $selected = [];

    public function render()
    {
        return view('livewire.builder.select-company', [
            'companies' => $this->getCompanies($this->selected, initial: true),
        ]);
    }

    public function getCompanies(array $_selectedCompanies = [], bool $initial = false)
    {
        if (!$initial) {
            $this->skipRender();
        }

        $term = "%$this->search%";

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
                        ->orWhere('ticker', 'ilike', $term)
                )
                ->whereNotIn('ticker', $_selectedCompanies)
                ->limit(6)
                ->get()
                ->toArray()
        ];
    }
}
