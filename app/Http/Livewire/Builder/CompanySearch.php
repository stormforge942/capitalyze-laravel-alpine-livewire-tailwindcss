<?php

namespace App\Http\Livewire\Builder;

use App\Models\Company;
use Livewire\Component;

class CompanySearch extends Component
{
    public $search = '';
    
    public function render()
    {
        return view('livewire.builder.company-search', [
            'companies' => $this->getCompanies(initial: true),
        ]);
    }

    public function getCompanies(array $selectedCompanies = [], bool $initial = false)
    {
        if (!$initial) {
            $this->skipRender();
        }

        $term = "%$this->search%";

        return Company::query()
            ->when(
                $this->search,
                fn ($q) => $q->where('name', 'ilike', $term)
                    ->orWhere('ticker', 'ilike', $term)
            )
            ->whereNotIn('ticker', $selectedCompanies)
            ->limit(6)
            ->get()
            ->toArray();
    }
}
