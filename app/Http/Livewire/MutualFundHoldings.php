<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\MutualFundsPage;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MutualFundHoldings extends Component
{
    public $cik;
    public $fund;
    public $fund_symbol;
    public $series_id;
    public $class_id;

    public string $selectedQuarter = '';
    public array $quarters = [];
    

    public function mount($cik, $fund,  Request $request)
    {
        $this->cik = $cik;
        $this->fund = $fund;
        $this->quarters = $this->generateQuarters();
        $this->selectedQuarter = !empty($this->quarters) ? array_key_first($this->quarters) : '';
        $selectedQuarter = $request->query('Quarter-to-view');
        if ($selectedQuarter && array_key_exists($selectedQuarter, $this->quarters)) {
            $this->selectedQuarter = $selectedQuarter;
        } else {
            $this->selectedQuarter = !empty($this->quarters) ? array_key_first($this->quarters) : '';
        }

        $this->updated('selectedQuarter', $this->selectedQuarter);
    }
    
    public function updatedSelectedQuarter()
    {
        $this->emitTo('mutual-fund-holdings-table', 'quarterChanged', $this->selectedQuarter);
        $this->dispatchBrowserEvent('updateUrl', ['selectedQuarter' => $this->selectedQuarter]);
    }

    public function generateQuarters()
    {
        $periodOfReport = MutualFundsPage::where('cik', $this->cik)
            ->where('fund_symbol', $this->fund_symbol)
            ->where('series_id', $this->series_id)
            ->where('class_id', $this->class_id)
            ->distinct()
            ->pluck('period_of_report')
            ->mapWithKeys(function ($period) {
                return [$period => $period];
            })
            ->toArray();
    
        return array_reverse($periodOfReport, true);
    }

    public function render()
    {
        return view('livewire.mutual-fund-holdings');
    }
}
