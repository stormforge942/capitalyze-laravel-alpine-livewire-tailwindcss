<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class CompanyChart extends Component
{
    public $company;
    public $ticker;
    public $period;
    public $currentChartPeriod = "3m";
    public $chartPeriods = ["3m", "6m", "1yr", "3yr", "5yr", "10yr", "all"];
    public $stockChart;

    public function mount($company, $ticker, $period)
    {

        $this->company = $company;
        $this->ticker = strtolower($ticker);
        $this->period = $period;
        $this->getCompanyStockChart();
    }

    public function getCompanyStockChart() {
        if($this->currentChartPeriod === 'all') {
            $query = DB::connection('pgsql-xbrl')
            ->table('eod_prices')
            ->where('symbol', $this->ticker)
            ->orderBy('date', 'desc');
        } else {
            $toDate = Carbon::now();

            if(Str::contains($this->currentChartPeriod, 'yr'))
            {
                $fromDate = Carbon::now()->subYear(5);
            }
            if(Str::contains($this->currentChartPeriod, 'm'))
            {
                $fromDate = Carbon::now()->subMonths(1);
            }

            $query = DB::connection('pgsql-xbrl')
            ->table('eod_prices')
            ->where('symbol', $this->ticker)
            ->whereBetween('date', [$fromDate, $toDate])
            ->orderBy('date', 'desc');
        }

        $results = $query->get()->toArray();

        $this->emit('getCompanyStockChart', $results);

        return $results;
    }

    public function setChartPeriod($chartPeriod)
    {
        $this->currentChartPeriod = $chartPeriod;
    }

    public function render()
    {
        return view('livewire.company-chart');
    }
}
