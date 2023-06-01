<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class FundSummary extends Component
{
    public array $topBuys;
    public array $topSells;
    public array $summary;
    public array $activity;
    public $latestQuarter;
    public $cik;
    public $fund;

    public function mount($cik, $fund) {
        $this->cik = $cik;
        $this->fund = $fund;
        $this->latestQuarter = DB::connection('pgsql-xbrl')->table('filings_summary')->max(DB::raw("TO_DATE(date, 'YYYY-MM-DD')"));

        $data = DB::connection('pgsql-xbrl')
        ->table('filings')
        ->select('change_in_shares', 'change_in_value', 'symbol', 'name_of_issuer')
        ->where('cik', '=', $cik)
        ->where('report_calendar_or_quarter', '=', $this->latestQuarter)
        ->orderByDesc('change_in_shares')
        ->limit(5)
        ->get()->toArray();
    

        $this->topBuys = $data;

        $data = DB::connection('pgsql-xbrl')
        ->table('filings')
        ->select('change_in_shares', 'change_in_value', 'symbol', 'name_of_issuer')
        ->where('cik', '=', $cik)
        ->where('report_calendar_or_quarter', '=', $this->latestQuarter)
        ->orderBy('change_in_shares')
        ->limit(5)
        ->get()->toArray();

        $this->topSells = $data;

        $data = DB::connection('pgsql-xbrl')
        ->table('filings')
        ->select('weight', 'symbol', 'name_of_issuer')
        ->where('cik', '=', $cik)
        ->where('report_calendar_or_quarter', '=', $this->latestQuarter)
        ->orderByDesc('weight')
        ->limit(4)
        ->get()->toArray();

        $this->activity = $data;


        $data = DB::connection('pgsql-xbrl')
        ->table('filings_summary')
        ->select('cik','investor_name','portfolio_size','added_securities','removed_securities','total_value','last_value','change_in_total_value','change_in_total_value_percentage','turnover','turnover_alt_sell','turnover_alt_buy','average_holding_period','average_holding_period_top10','average_holding_period_top20','url')
        ->where('cik', '=', $cik)
        ->where('date', '=', $this->latestQuarter)
        ->limit(1)
        ->get();
    
        $this->summary = $data->isEmpty() ? [] : (array) $data->first();

    }

    public function allHoldings() {
        return redirect()->to('/fund/'.$this->cik.'/holdings');
    }

    public function render()
    {
        return view('livewire.fund-summary');
    }
}
