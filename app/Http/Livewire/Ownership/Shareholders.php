<?php

namespace App\Http\Livewire\Ownership;

use App\Http\Livewire\AsTab;
use Livewire\Component;
use App\Models\CompanyFilings;
use Illuminate\Support\Carbon;

class Shareholders extends Component
{
    use AsTab;

    public string $ticker;
    public $quarters;
    public $quarter = null;
    public string $search = '';

    public function mount(array $data = [])
    {
        $this->ticker = $data['company']['ticker'];
        $this->quarters = $this->quarters();

        if (!array_key_exists($this->quarter, $this->quarters)) {
            $this->quarter = array_key_first($this->quarters);
        }
    }

    public function render()
    {
        return view('livewire.ownership.shareholders', [
            'quarters' => $this->quarters,
        ]);
    }

    public function updated($prop)
    {
        if (in_array($prop, ['quarter', 'search'])) {
            $this->emitTo(ShareholdersTable::class, 'filtersChanged', [
                'quarter' => $this->quarter,
                'search' => $this->search,
            ]);
        }
    }

    private function quarters(): array
    {
        $quarters = [];
        $oldestFiling = CompanyFilings::query()->where('symbol', $this->ticker)->min('report_calendar_or_quarter');
        $startYear = Carbon::parse($oldestFiling)->year;
        $startQuarter = Carbon::parse($oldestFiling)->quarter;
        $currentYear = now()->year;
        $currentQuarter = now()->quarter;
        $currentDay = now()->day;
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

        for ($year = $startYear; $year <= $currentYear; $year++) {
            $startQuarter = ($year == $startYear) ? $startQuarter : 1;
            for ($quarter = $startQuarter; $quarter <= 4; $quarter++) {
                if ($year == $currentYear && $quarter > $currentQuarter) {
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
