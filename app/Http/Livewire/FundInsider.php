<?php

namespace App\Http\Livewire;
use App\Models\CompanyInsider;

use Livewire\Component;

class FundInsider extends Component
{
    public $fund;
    public $cik;
    public bool $hasResults = false;

    public function mount($fund, $cik)
    {
        $this->fund = $fund;
        $this->cik = $cik;
        $query = CompanyInsider::query()
        ->where('reporting_cik', '=', $this->cik);
    
        $this->hasResults = $query->exists();

    }

    public function render()
    {
        return view('livewire.fund-insider');
    }
}
