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
    }

    public function render()
    {
        return view('livewire.ownership.shareholder-summary');
    }

    public function getLatestQuarter()
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
}
