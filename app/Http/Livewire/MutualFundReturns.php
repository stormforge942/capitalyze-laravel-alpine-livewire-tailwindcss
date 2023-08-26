<?php

namespace App\Http\Livewire;

use App\Models\MutualFundsReturn;
use Livewire\Component;

class MutualFundReturns extends Component
{
    public $fund;
    public $cik;
    public $fund_symbol;
    public $series_id;
    public $class_id;
    public bool $hasResults = false;

    public function mount($fund, $cik)
    {
        $this->fund = $fund;
        $this->cik = $cik;
        
        $query = MutualFundsReturn::query()
        ->where('cik', '=', str_pad($this->cik, 10, "0", STR_PAD_LEFT))
        ->where('symbol', '=', $this->fund_symbol)
        ->where('series_id', '=', $this->series_id)
        ->where('class_id', '=', $this->class_id);

        $this->hasResults = $query->exists();
     
    }

    public function render()
    {
        return view('livewire.mutual-fund-returns');
    }
}
