<?php

namespace App\Http\Livewire\Ownership;

use App\Http\Livewire\AsTab;
use Livewire\Component;
use App\Models\CompanyFilings;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

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
        $cacheKey = 'shareholders_date_range' . $this->ticker;

        $dateRange = Cache::remember($cacheKey, 3600, function () {
            $dates = CompanyFilings::query()
                ->where('symbol', $this->ticker)
                ->select([DB::raw('min(report_calendar_or_quarter) as start'), DB::raw('max(report_calendar_or_quarter) as end')])
                ->first()
                ->toArray();

            $start = Carbon::parse($dates['start'] ?: now()->toDateString());
            $end = Carbon::parse($dates['end'] ?: now()->toDateString());

            return [$start, $end];
        });

        return generate_quarter_options($dateRange[0], $dateRange[1], ' 13F Filings');
    }
}
