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
        ->select('industry_title', 'weight', 'date')
        ->orderByDesc('weight')
        ->get();
    
        $chartData = [];
        
        foreach ($investments as $investment) {
            $quarter = $investment->date;
            $industry = $investment->industry_title;
            $weight = $investment->weight;
        
            if (!isset($chartData[$quarter])) {
                $chartData[$quarter] = [];
            }
        
            if (count($chartData[$quarter]) < 15) { // Ensure there are only up to 15 industries per quarter.
                $chartData[$quarter][$industry] = $weight;
            }
        }
        
        // Sort the array by keys (dates).
        uksort($chartData, function($a, $b) {
            return strtotime($a) - strtotime($b);
        });
        
        // To ensure the data of the last quarter is also limited to 15 industries.
        end($chartData);
        $key = key($chartData);
        $chartData[$key] = array_slice($chartData[$key], 0, 15, true);
        
        $this->emit('renderChart', $chartData);
        $this->emit('renderIndustryDistribution', end($chartData));
        
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
