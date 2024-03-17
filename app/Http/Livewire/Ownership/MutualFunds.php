<?php

namespace App\Http\Livewire\Ownership;

use Livewire\Component;
use App\Http\Livewire\AsTab;
use Illuminate\Support\Carbon;
use App\Models\MutualFundsPage;
use Illuminate\Support\Facades\DB;

class MutualFunds extends Component
{
    use AsTab;

    public string $ticker;
    public array $quarters;
    public array $filters = [
        'periodRange' => null,
        'quarter' => null,
        'search' => ''
    ];

    public function mount(array $data = [])
    {
        $this->ticker = $data['company']['ticker'];

        $this->quarters = $this->quarters();
    }

    public function render()
    {
        return view('livewire.ownership.mutual-funds');
    }

    public function updatedFilters()
    {
        $this->emitTo(MutualFundsTable::class, 'filtersChanged', $this->filters);
    }

    public function quarters()
    {
        $quarters = [];

        $periods =  MutualFundsPage::query()
            ->where([
                'symbol' => $this->ticker,
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
