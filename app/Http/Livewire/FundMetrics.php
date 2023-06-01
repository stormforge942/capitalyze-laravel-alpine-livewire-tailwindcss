<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class FundMetrics extends Component
{
    public $cik;
    public $fund;

    public function mount($cik, $fund) {
        $this->cik = $cik;
        $this->fund = $fund;
    }

    public function getInvestorData()
    {
        $investments = DB::connection('pgsql-xbrl')
        ->table('industry_summary')
        ->where('cik', '=', $this->cik)
        ->where('weight', '>', '1')
        ->select('industry_title', 'weight', 'date')
        ->orderBy('weight')
        ->get();

        $chartData = [];

        foreach ($investments as $investment) {
            $quarter = $investment->date;
            $industry = $investment->industry_title;
            $weight = $investment->weight;

            if (!isset($chartData[$quarter])) {
                $chartData[$quarter] = [];
            }

            $chartData[$quarter][$industry] = $weight;
        }

        $this->emit('renderChart', $chartData);

        return $chartData;
    }

    public function getTotalValue()
    {
        $totalValues = DB::connection('pgsql-xbrl')
        ->table('filings_summary')
        ->where('cik', '=', $this->cik)
        ->select('date', 'total_value')
        ->orderBy('total_value')
        ->get();

        $chartData = [];

        foreach ($totalValues as $value) {
            $quarter = $value->date;
            $total = $value->total_value;

            $chartData[$quarter] = $total;
        }

        $this->emit('renderValue', $chartData);

        return $chartData;
    }

    public function render()
    {
        return view('livewire.fund-metrics');
    }
}
