<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\CompanyFilings;
use Carbon\Carbon;

class CompanyShareholders extends Component
{
    public $company;
    public $ticker;
    public $period;
    public string $selectedQuarter = '';
    public array $quarters = [];

    public function mount($company, $ticker, $period)
    {
        $this->company = $company;
        $this->ticker = $ticker;
        $this->period = $period;
        $this->quarters = $this->generateQuarters();
        $this->selectedQuarter = array_key_first($this->quarters);
        $this->updatedSelectedQuarter();
    }

    public function updatedSelectedQuarter()
    {
        $this->emitTo('company-shareholders-table', 'quarterChanged', $this->selectedQuarter);
    }

    public function generateQuarters()
    {
        $quarters = [];
        $oldestFiling = CompanyFilings::min('first_added');
        $startYear = Carbon::parse($oldestFiling)->year;
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
    
        for ($year = $startYear; $year <= $currentYear; $year++) {
            for ($quarter = 1; $quarter <= 4; $quarter++) {
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
    

    public function render()
    {
        return view('livewire.company-shareholders');
    }
}
