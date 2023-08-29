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
    public $selectedFilingDate;

    protected $listener = ["updateSelectedFilingDate" => "update"];

    public function mount($company, $ticker, $period)
    {
        $this->company  = $company;
        $this->ticker = $ticker;
        $this->period = $period;
        $query = DB::connection('pgsql-xbrl')
            ->table('public.executive_compensation')
            ->where('symbol', $this->ticker)
            ->orderBy('filing_date', 'desc')
            ->distinct()
            ->pluck('filing_date'); // Pluck only the filing dates
        $this->executiveCompensations = $query;
    }

    public function update($value)
    {
        $this->selectedFilingDate = $value;
    }

    public function render()
    {
        return view('livewire.company-executive-compensation');
    }
}
