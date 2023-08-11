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
    public $currentChartPeriod = "3m";
    public $chartPeriods = ["3m", "6m", "1yr", "3yr", "5yr", "10yr", "all"];

    public function mount($company, $ticker, $period)
    {

        $this->company = $company;
        $this->ticker = strtolower($ticker);
        $this->period = $period;
        $this->getCompanyStockChart();
    }

    public function getCompanyStockChart() {
        $query = DB::connection('pgsql-xbrl')
            ->table('eod_prices')
            ->where('symbol', $this->ticker);

        $toDate = Carbon::now();
            
        switch ($this->currentChartPeriod) {
            case '3m':
                $fromDate = Carbon::now()->subMonths(3);
                $query->whereBetween('date', [$fromDate, $toDate]);
                break;

            case '6m':
                $fromDate = Carbon::now()->subMonths(6);
                $query->whereBetween('date', [$fromDate, $toDate]);
                break;

            case '1yr':
                $fromDate = Carbon::now()->subYear(1);
                $query->whereBetween('date', [$fromDate, $toDate]);
                break;

            case '3yr':
                $fromDate = Carbon::now()->subYear(3);
                $query->whereBetween('date', [$fromDate, $toDate]);
                break;

            case '5yr':
                $fromDate = Carbon::now()->subYear(5);
                $query->whereBetween('date', [$fromDate, $toDate]);
                break;

            case '10yr':
                $fromDate = Carbon::now()->subYear(10);
                $query->whereBetween('date', [$fromDate, $toDate]);
                break;

            case 'all':
            default:
                break;
        }

        $results = $query->orderBy('date', 'desc')->get()->toArray();

        $queryAllData = DB::connection('pgsql-xbrl')
            ->table('eod_prices')
            ->where('symbol', $this->ticker);

        $resultsAllData = $queryAllData->orderBy('date', 'asc')->get()->toArray();

        $this->emit('getAllData', $resultsAllData);

        $this->emit('getCompanyStockChart', $results);
    }

    public function setChartPeriod($chartPeriod)
    {
        $this->currentChartPeriod = $chartPeriod;
        $this->getCompanyStockChart();
    }

    public function render()
    {
        return view('livewire.company-chart');
    }
}
