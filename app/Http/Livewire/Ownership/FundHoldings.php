<?php

namespace App\Http\Livewire\Ownership;

use Livewire\Component;
use App\Http\Livewire\AsTab;
use App\Models\CompanyFilings;
use Illuminate\Support\Carbon;

class FundHoldings extends Component
{
    use AsTab;

    public $cik;
    public $quarters;
    public $quarter = null;
    public string $search = '';

    public static function title(): string
    {
        return 'Holdings';
    }

    public function mount(array $data = [])
    {
        $this->cik = $data['fund']['cik'];

        $this->quarters = $this->quarters();
        if (!array_key_exists($this->quarter, $this->quarters)) {
            $this->quarter = array_key_first($this->quarters);
        }
    }

    public function render()
    {
        return view('livewire.ownership.fund-holdings');
    }

    public function updated($prop)
    {
        if (in_array($prop, ['quarter', 'search'])) {
            $this->emitTo(FundHoldingsTable::class, 'filtersChanged', [
                'quarter' => $this->quarter,
                'search' => $this->search,
            ]);
        }
    }

    private function quarters()
    {
        $quarters = [];
        $oldestFiling = CompanyFilings::where('cik', $this->cik)->min('report_calendar_or_quarter');
        $newestFiling = CompanyFilings::where('cik', $this->cik)->max('report_calendar_or_quarter');
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
}
