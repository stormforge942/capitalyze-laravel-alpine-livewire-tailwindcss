<?php

namespace App\Http\Livewire\Ownership;

use App\Http\Livewire\AsTab;
use Livewire\Component;
use App\Models\CompanyFilings;
use App\Models\CompanyProfile;
use App\Models\MutualFundsPage;
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
        $chartData = [];

        $chartData['fund'] = $this->getFundsData();
        $chartData['mutual'] = $this->getMutualFundsData();

        return $chartData;
    }

    private function getFundsData()
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

    private function getMutualFundsData()
    {
        try {
            $start = Carbon::parse($this->quarter)->startOfQuarter();
            $end = Carbon::parse($this->quarter)->endOfQuarter();

            // Fetch the CIK (Central Index Key)
            $companyProfile = CompanyProfile::query()
                ->where('symbol', '=', $this->ticker)
                ->select('cik')
                ->first();

            if (!$companyProfile || !$companyProfile->cik) {
                throw new \Exception('CIK not found for the given ticker.');
            }

            $cik = $companyProfile->cik;

            // Fetch the total value from issued_shares
            $issuedShares = DB::connection('pgsql-xbrl')
                ->table('issued_shares')
                ->where('cik', '=', $cik)
                ->whereBetween('date', [$start, $end])
                ->first();

            if (!$issuedShares || !$issuedShares->value) {
                throw new \Exception('Total value not found for the given CIK and quarter.');
            }

            $totalValue = $issuedShares->value;

            // Fetch mutual funds data
            $mutualFunds = MutualFundsPage::query()
                ->where('symbol', '=', $this->ticker)
                ->when($this->quarter, function ($query) use($start, $end) {
                    return $query->whereBetween('period_of_report', [$start, $end]);
                })
                ->orderByDesc('balance')
                ->limit(15)
                ->get();

            // Prepare chart data
            $items = $mutualFunds->map(function ($item) {
                return [
                    'balance' => $item->balance,
                    'name' => $item->registrant_name . ' (' . $item->fund_symbol . ')',
                ];
            })->toArray();

            $chartData = [];

            foreach ($items as $item) {
                $name = $item['name'];
                $balance = $item['balance'];
                $chartData[$name] = round($balance / $totalValue * 100, 4);
            }

            return $chartData;

        } catch (\Exception $e) {
            Log::error('Error fetching mutual funds data: ' . $e->getMessage());

            return [];
        }
    }

    public function render()
    {
        return view('livewire.ownership.funds-summary', [
            'quarters' => $this->quarters,
        ]);
    }
}
