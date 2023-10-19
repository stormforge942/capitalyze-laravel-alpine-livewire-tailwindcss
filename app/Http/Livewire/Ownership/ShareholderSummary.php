<?php

namespace App\Http\Livewire\Ownership;

use Livewire\Component;
use App\Http\Livewire\AsTab;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ShareholderSummary extends Component
{
    use AsTab;

    public string $quarter = '';
    public $activity;
    public $cik;
    public $topBuys;
    public $topSells;
    public $summary;

    public static function title(): string
    {
        return 'Summary';
    }

    public function mount(array $data)
    {
        $this->cik = $data['fund']['cik'];

        $this->quarter = $this->getLatestQuarter();

        $this->activity = DB::connection('pgsql-xbrl')
            ->table('filings')
            ->select('weight', 'symbol', 'name_of_issuer')
            ->where('cik', '=', $this->cik)
            ->where('report_calendar_or_quarter', '=', $this->quarter)
            ->orderByDesc('weight')
            ->limit(4)
            ->get()
            ->toArray();

        $this->topBuys =  DB::connection('pgsql-xbrl')
            ->table('filings')
            ->select('change_in_shares', 'change_in_value', 'symbol', 'name_of_issuer')
            ->where('cik', '=', $this->cik)
            ->where('report_calendar_or_quarter', '=', $this->quarter)
            ->orderByDesc('change_in_shares')
            ->where('change_in_shares', '>', 0)
            ->limit(8)
            ->get()
            ->toArray();

        $this->topSells = DB::connection('pgsql-xbrl')
            ->table('filings')
            ->select('change_in_shares', 'change_in_value', 'symbol', 'name_of_issuer')
            ->where('cik', '=', $this->cik)
            ->where('report_calendar_or_quarter', '=', $this->quarter)
            ->orderBy('change_in_shares')
            ->limit(8)
            ->get()
            ->toArray();

        $this->summary = $this->getSummary();
    }

    public function render()
    {
        return view('livewire.ownership.shareholder-summary');
    }

    private function getLatestQuarter()
    {
        $latestFiling = Carbon::parse(DB::connection('pgsql-xbrl')
            ->table('filings_summary')
            ->where('cik', '=', $this->cik)
            ->max('date'));

        if (!$latestFiling) {
            throw new \Exception('No filings found for this fund');
        }

        $quarterEnd = [
            1 => 31,
            2 => 30,
            3 => 30,
            4 => 31,
        ];

        $year = $latestFiling->year;
        $quarter = $latestFiling->quarter;

        $currentYear = now()->year;
        $currentQuarter = now()->quarter;
        $currentDay = now()->day;

        // Don't include the current quarter if it's not over yet
        if (
            $year == $currentYear &&
            $quarter == $currentQuarter &&
            $currentDay < $quarterEnd[$quarter]
        ) {
            // If it's the first quarter, go back to the previous year
            if ($quarter == 1) {
                $year--;
                $quarter = 4;
            } else {
                $quarter--;
            }
        }

        return "$year-" . str_pad(($quarter * 3), 2, "0", STR_PAD_LEFT) . "-{$quarterEnd[$quarter]}";
    }

    private function getSummary()
    {
        $data = DB::connection('pgsql-xbrl')
            ->table('filings_summary')
            ->select('cik', 'investor_name', 'portfolio_size', 'added_securities', 'removed_securities', 'total_value', 'last_value', 'change_in_total_value', 'change_in_total_value_percentage', 'turnover', 'turnover_alt_sell', 'turnover_alt_buy', 'average_holding_period', 'average_holding_period_top10', 'average_holding_period_top20', 'url')
            ->where('cik', '=', $this->cik)
            ->where('date', '=', $this->quarter)
            ->limit(1)
            ->get();

        $summary = $data->isEmpty() ? [] : (array) $data->first();

        if (!empty($summary)) {
            $percentageFields = [
                'change_in_total_value_percentage',
                'turnover',
                'turnover_alt_sell',
                'turnover_alt_buy'
            ];

            foreach ($percentageFields as $field) {
                if (isset($summary[$field])) {
                    $summary[$field] = number_format($summary[$field], 2) . ' %';
                }
            }
        }

        return $summary;
    }
}
