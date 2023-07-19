<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Company;

class SearchComponent extends Component
{
    public $search;
    protected $results = [];
    public $showText = false;
    protected $listeners = ['showText'];


    public function updatedSearch()
    {

        // dd($this->search);
        $this->results = Company::where('ticker', 'ilike', '%' . $this->search . '%')
        ->orWhere('name', 'ilike', '%' . $this->search . '%')
        ->paginate(10);

    }

    public function showText()
    {
        $this->showText = true;
    }
    
    public function render()
    {
        return view('livewire.search-component', [
            'results' => $this->results,
        ]);
    }

    public function hideText()
    {
        $this->search = "";
        $this->showText = false;
    }

    public function redirectToProduct($ticker)
    {
        return redirect()->route('company.product', ['ticker' => $ticker]);
    }
}
