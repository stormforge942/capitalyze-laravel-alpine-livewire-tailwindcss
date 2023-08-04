<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class CompanyExecutiveCompensation extends Component
{
    public $company;
    public $ticker;
    public $period;
    public $executiveCompensations;

    public function mount($company, $ticker, $period)
    {

        $this->company  = $company;
        $this->ticker = $ticker;
        $this->period = $period;
        $this->getExecutiveCompensation();
    }

    public function getExecutiveCompensation() {
        $this->executiveCompensations = DB::connection('pgsql-xbrl')
        ->table('executive_compensation')
        ->where('symbol', $this->ticker)
        ->orderBy('filing_date', 'desc')
        ->limit(100)->get()->toArray();
    }

    public function render()
    {
        return view('livewire.company-executive-compensation');
    }
}
