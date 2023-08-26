<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CompanyRestatement;

class FundRestatement extends Component
{
    public $fund;
    public $cik;
    public bool $hasResults = false;

    public function mount($fund, $cik)
    {

        $this->fund = $fund;
        $this->cik = $cik;

        $query = CompanyRestatement::query()
        ->where('cik', '=', str_pad($this->cik, 10, "0", STR_PAD_LEFT));

        $this->hasResults = $query->exists();
    }
    
    public function render()
    {
        return view('livewire.fund-restatement');
    }
}
