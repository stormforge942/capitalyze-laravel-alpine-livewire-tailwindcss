<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class CompanyChart extends Component
{
    public $company;
    public $ticker;
    public $period;
    public $stockChart;

    public function mount($company, $ticker, $period)
    {

        $this->company  = $company;
        $this->ticker = strtolower($ticker);
        $this->period = $period;
        $this->getCompanyStockChart();
    }

    public function getCompanyStockChart() {
        $query = DB::connection('pgsql-xbrl')
        ->table('eod_prices')
        ->where('symbol', $this->ticker)
        ->limit(100)
        ->orderBy('date', 'desc');

        $results = $query->get()->toArray();

        $this->emit('getCompanyStockChart', $results);

        return $results;
    }

    public function render()
    {
        return view('livewire.company-chart');
    }
}
