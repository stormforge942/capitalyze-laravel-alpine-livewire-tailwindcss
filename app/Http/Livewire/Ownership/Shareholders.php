<?php

namespace App\Http\Livewire\Ownership;

use App\Http\Livewire\Tab;
use App\Models\CompanyFilings;
use Illuminate\Support\Carbon;
use Livewire\WithPagination;

class Shareholders extends Tab
{
    use WithPagination;
    
    public $company;
    public array $quarters = [];
    public string $quarter = '';

    public function mount(array $data = [])
    {
        $this->company = $data['company'];
        $this->quarters = $this->quarters();
    }

    public function render()
    {
        $filings = CompanyFilings::query()
            ->where('symbol', '=', $this->company['ticker'])
            ->when(
                $this->quarter,
                fn ($q) => $q->where('report_calendar_or_quarter', '=', $this->quarter)
            )
            ->paginate(10);

        return view('livewire.ownership.shareholders', [
            'filings' => $filings,
        ]);
    }

    private function quarters(): array
    {
        $quarters = [];
        $oldestFiling = CompanyFilings::query()->where('symbol', $this->company['ticker'])->min('report_calendar_or_quarter');
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
