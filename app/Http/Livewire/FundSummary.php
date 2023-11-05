<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class FundSummary extends Component
{
    public $cik;
    public $fund;
    public $quarters;
    public $selectedQuarter;
    public $topBuys;
    public $topSells;
    public $summary;
    public $activity;

    public function mount($cik, $fund)
    {
        $this->cik = $cik;
        $this->fund = $fund;
        $this->quarters = $this->generateQuarters();
        $this->selectedQuarter = array_key_first($this->quarters);
        $this->loadFundData($this->selectedQuarter);
    }

    public function loadFundData($quarter) {
        $data = DB::connection('pgsql-xbrl')
        ->table('filings')
        ->select('change_in_shares', 'change_in_value', 'symbol', 'name_of_issuer')
        ->where('cik', '=', $this->cik)
        ->where('report_calendar_or_quarter', '=', $quarter)
        ->orderByDesc('change_in_shares')
        ->limit(5)
        ->get()->toArray();
    
        $this->emit('getTopBuys', $data);
        $this->topBuys = $data;

        $data = DB::connection('pgsql-xbrl')
        ->table('filings')
        ->select('change_in_shares', 'change_in_value', 'symbol', 'name_of_issuer')
        ->where('cik', '=', $this->cik)
        ->where('report_calendar_or_quarter', '=', $quarter)
        ->orderBy('change_in_shares')
        ->limit(5)
        ->get()->toArray();

        $this->emit('getTopSells', $data);
        $this->topSells = $data;

        $data = DB::connection('pgsql-xbrl')
        ->table('filings')
        ->select('weight', 'symbol', 'name_of_issuer')
        ->where('cik', '=', $this->cik)
        ->where('report_calendar_or_quarter', '=', $quarter)
        ->orderByDesc('weight')
        ->limit(4)
        ->get()->toArray();

        $this->activity = $data;


        $data = DB::connection('pgsql-xbrl')
        ->table('filings_summary')
        ->select('cik','investor_name','portfolio_size','added_securities','removed_securities','total_value','last_value','change_in_total_value','change_in_total_value_percentage','turnover','turnover_alt_sell','turnover_alt_buy','average_holding_period','average_holding_period_top10','average_holding_period_top20','url')
        ->where('cik', '=', $this->cik)
        ->where('date', '=', $quarter)
        ->limit(1)
        ->get();
    
        $this->summary = $data->isEmpty() ? [] : (array) $data->first();

        if (!empty($this->summary)) {
            $percentageFields = [
                'change_in_total_value_percentage',
                'turnover',
                'turnover_alt_sell',
                'turnover_alt_buy'
            ];
        
            foreach ($percentageFields as $field) {
                if (isset($this->summary[$field])) {
                    $this->summary[$field] = number_format($this->summary[$field], 2) . ' %';
                }
            }
        }
    }

    public function updatedSelectedQuarter($quarter)
    {
        $this->loadFundData($quarter);
    }

    public function generateQuarters()
    {
        $quarters = [];

        $oldestFiling = DB::connection('pgsql-xbrl')
        ->table('filings_summary')
        ->where('cik', '=', $this->cik)
        ->min('date');
    
        $newestFiling = DB::connection('pgsql-xbrl')
        ->table('filings_summary')
        ->where('cik', '=', $this->cik)
        ->max('date');

        $startYear = Carbon::parse($oldestFiling)->year;
        $startQuarter = Carbon::parse($oldestFiling)->quarter;
        $endYear = Carbon::parse($newestFiling)->year;
        $endQuarter = Carbon::parse($newestFiling)->quarter;
        $currentYear = Carbon::now()->year;
        $currentQuarter = Carbon::now()->quarter;
        $currentDay = Carbon::now()->day;
        $quarterEndDates = [
            1 => '-03-31',
            2 => '-06-30',
            3 => '-09-30',
            4 => '-12-31',
        ];
        $quarterEndDays = [
            1 => 31,
            2 => 30,
            3 => 30,
            4 => 31,
        ];
    
        for ($year = $startYear; $year <= $endYear; $year++) {
            $startQuarter = ($year == $startYear) ? $startQuarter : 1;
            for ($quarter = $startQuarter; $quarter <= 4; $quarter++) {
                if ($year == $currentYear && $quarter > $currentQuarter) {
                    break;
                }
                if ($year == $endYear && $quarter > $endQuarter) {
                    break;
                }
                // Don't include the current quarter if it's not over yet
                if ($year == $currentYear && $quarter == $currentQuarter && $currentDay < $quarterEndDays[$quarter]) {
                    continue;
                }
                $quarterEnd = $year . $quarterEndDates[$quarter];
                $quarterText = 'Q' . $quarter . ' ' . $year . ' 13F Filings';
                $quarters[$quarterEnd] = $quarterText;
            }
        }
    
        return array_reverse($quarters, true);
    }

    public function render()
    {
        return view('livewire.fund-summary');
    }
}
