<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\CompanySymbolSummary;

class CompanySummary extends Component
{
    public $company;
    public $ticker;
    public $period;
    public $quarters;
    public $selectedQuarter;
    public $summary;

    public function mount($company, $ticker, $period)
    {
        $this->company = $company;
        $this->ticker = $ticker;
        $this->period = $period;
        $this->quarters = $this->generateQuarters();
        $this->selectedQuarter = array_key_first($this->quarters);
        $this->loadSummaryData($this->selectedQuarter);
    }

    public function loadSummaryData($quarter)
    {
        $summary = CompanySymbolSummary::where('symbol', $this->ticker)->where('date', $quarter)->first();

        // convert the Eloquent model instance to a simple PHP object
        $this->summary = $summary ? $summary->toArray() : null;
    }

    public function updatedSelectedQuarter($quarter)
    {
        $this->loadSummaryData($quarter);
    }

    public function generateQuarters()
    {
        $quarters = [];
        $oldestFiling = CompanySymbolSummary::where('symbol', $this->ticker)->min('date');
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
                $quarterText = 'Q' . $quarter . ' ' . $year;
                $quarters[$quarterEnd] = $quarterText;
            }
        }
    
        return array_reverse($quarters, true);
    }
    
    public function render()
    {
        $rows = [
            'Funds Holding' => [
                'value' => 'investors_holding',
                'prior' => 'last_investors_holding',
                'change' => 'investors_holding_change',
            ],
            '13F shares' => [
                'value' => 'thirteenf_shares',
                'prior' => 'last_thirteenf_shares',
                'change' => 'thirteenf_shares_change',
            ],
            '% Ownership' => [
                'value' => 'ownership_percent',
                'prior' => 'last_ownership_percent',
                'change' => 'ownership_percent_change',
            ],
            'New Positions' => [
                'value' => 'new_positions',
                'prior' => 'last_new_positions',
                'change' => 'new_positions_change',
            ],
            'Increased Positions' => [
                'value' => 'increased_positions',
                'prior' => 'last_increased_positions',
                'change' => 'increased_positions_change',
            ],
            'Closed Positions' => [
                'value' => 'closed_positions',
                'prior' => 'last_closed_positions',
                'change' => 'closed_positions_change',
            ],
            'Reduced Positions' => [
                'value' => 'reduced_positions',
                'prior' => 'last_reduced_positions',
                'change' => 'reduced_positions_change',
            ],
            'Total Calls' => [
                'value' => 'total_calls',
                'prior' => 'last_total_calls',
                'change' => 'total_calls_change',
            ],
            'Total Puts' => [
                'value' => 'total_puts',
                'prior' => 'last_total_puts',
                'change' => 'total_puts_change',
            ],
            'PUT/CALL Ratio' => [
                'value' => 'put_call_ratio',
                'prior' => 'last_put_call_ratio',
                'change' => 'put_call_ratio_change',
            ],
        ];
    
        return view('livewire.company-summary', ['rows' => $rows, 'summary' => $this->summary]);
    }
    
}
