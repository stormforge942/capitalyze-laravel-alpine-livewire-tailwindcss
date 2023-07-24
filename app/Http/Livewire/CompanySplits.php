<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class CompanySplits extends Component
{
    public $company;
    public $ticker;
    public $period;
    public $stockSplits;

    public function mount($company, $ticker, $period)
    {

        $this->company  = $company;
        $this->ticker = strtolower($ticker);
        $this->period = $period;
        $this->getCompanyStockSplits();
    }

    public function getCompanyStockSplits() {
        $this->stockSplits = DB::connection('pgsql-xbrl')->table('splits')->select('*')->where('symbol', $this->ticker)->get()->toArray();
    }

    public function render()
    {
        return view('livewire.company-splits');
    }
}
