<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Company;

class SearchComponent extends Component
{
    public $search;
    protected $results = [];

    public function updatedSearch()
    {
        $this->results = Company::where('ticker', 'ilike', '%' . $this->search . '%')
        ->orWhere('name', 'ilike', '%' . $this->search . '%')
        ->paginate(10);

    }

    public function render()
    {
        return view('livewire.search-component', [
            'results' => $this->results,
        ]);
    }

    public function redirectToProduct($ticker)
    {
        return redirect()->route('company.product', ['ticker' => $ticker]);
    }
}
