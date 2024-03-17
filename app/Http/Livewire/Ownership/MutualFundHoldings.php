<?php

namespace App\Http\Livewire\Ownership;

use Livewire\Component;
use App\Http\Livewire\AsTab;
use App\Models\MutualFundsPage;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MutualFundHoldings extends Component
{
    use AsTab;

    public $fund;
    public $quarters;
    public array $filters = [
        'periodRange' => null,
        'quarter' => null,
        'search' => ''
    ];
    public $redirectToOverview = false;

    public static function title(): string
    {
        return 'Holdings';
    }

    public function mount(array $data = [])
    {
        $this->fund = $data['fund'];
        $this->redirectToOverview = request()->get('from') === 'track-investors';
        $this->quarters = $this->quarters();
    }

    public function render()
    {
        return view('livewire.ownership.mutual-fund-holdings');
    }

    public function updatedFilters()
    {
        $this->emitTo(MutualFundHoldingsTable::class, 'filtersChanged', $this->filters);
    }

    public function quarters()
    {
        $quarters = [];

        $periods =  MutualFundsPage::query()
            ->where([
                'fund_symbol' => $this->fund['fund_symbol'],
                'cik' => $this->fund['cik'],
                'series_id' => $this->fund['series_id'],
                'class_id' => $this->fund['class_id'],
                'class_name' => $this->fund['class_name'],
            ])
            ->select(
                DB::raw('MIN(period_of_report) as min'),
                DB::raw('MAX(period_of_report) as max')
            )
            ->first();

        if (!$periods) {
            return $quarters;
        }

        $min = Carbon::parse($periods->min)->startOfQuarter();
        $max = Carbon::parse($periods->max)->endOfQuarter();

        // get all the quarters in the format QX-YYYY
        while ($min->lte($max)) {
            $key = $min->clone()->startOfQuarter()->format('Y-m-d') . '|' . $min->clone()->endOfQuarter()->format('Y-m-d');
            $value = 'Q' . $min->quarter . '-' . $min->year;
            $quarters[$key] = $value;

            $min->addQuarter();
        }

        $quarters = array_reverse($quarters);

        $this->filters['quarter'] = array_key_first($quarters);

        return $quarters;
    }
}
