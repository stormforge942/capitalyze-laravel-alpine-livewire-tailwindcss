<?php

namespace App\Http\Livewire\Ownership;

use App\Http\Livewire\AsTab;
use Livewire\Component;
use App\Models\CompanyFilings;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class FundsSummary extends Component
{
    use AsTab;

    public string $ticker;
    public $quarters;
    public $quarter = null;
    public $chartData;

    public function mount(array $data = [])
    {
        $this->ticker = $data['company']['ticker'];
        $this->quarters = $this->quarters();

        if (!array_key_exists($this->quarter, $this->quarters)) {
            $this->quarter = array_key_first($this->quarters);
        }

        $this->chartData = $this->getChartData();
    }

    public function updated($param)
    {
        if ($param === 'quarter') {
            $this->chartData = $this->getChartData();
        }
    }

    private function quarters(): array
    {
        $cacheKey = 'ownership_summary_quarters' . $this->ticker;

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

    public function getChartData()
    {
        $funds = CompanyFilings::query()
            ->where('symbol', '=', $this->ticker)
            ->when($this->quarter, function ($query) {
                return $query->where('report_calendar_or_quarter', '=', $this->quarter);
            })
            ->orderByDesc('ownership')
            ->limit(15)
            ->get();
        
        $chartData = [];

        foreach ($funds as $fund) {
            $chartData[$fund->investor_name] = $fund->ownership;
        }

        return $chartData;
    }

    public function render()
    {
        return view('livewire.ownership.funds-summary', [
            'quarters' => $this->quarters,
        ]);
    }
}
