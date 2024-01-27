<?php

namespace App\Http\Livewire\Ownership;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Http\Livewire\AsTab;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class MutualFundSummary extends Component
{
    use AsTab;

    public $fund;
    public $cik = '';
    public $quarter = '';

    public static function title(): string
    {
        return 'Summary';
    }

    public function mount(array $data)
    {
        $this->fund = $data['fund'];
        $this->quarter = $this->getLatestQuarter();
    }

    public function render()
    {
        return view('livewire.ownership.mutual-fund-summary');
    }

    public function getSummary()
    {
        $summary = (array) DB::connection('pgsql-xbrl')
            ->table('mutual_fund_holdings_summary')
            ->select('cik', 'series_id', 'class_id',  'registrant_name', 'portfolio_size', 'added_securities', 'removed_securities', 'total_value', 'previous_value', 'change_in_total_value', 'change_in_total_value_percentage', 'turnover', 'turnover_alt_sell', 'turnover_alt_buy', 'average_holding_period', 'average_holding_period_top10', 'average_holding_period_top20')
            ->where($this->fundPrimaryKey())
            ->where('date', $this->quarter)
            ->first() ?? [];

        $percentageFields = [
            'change_in_total_value_percentage',
            'turnover',
            'turnover_alt_sell',
            'turnover_alt_buy'
        ];

        foreach ($summary as $key => $value) {
            if (in_array($key, $percentageFields)) {
                $value = round($value, 2) . ' %';
            }

            $type = Str::startsWith($value, 'https') ? 'link' : 'text';

            if ($key === 'url') {
                $value = getSiteNameFromUrl($value);
            }

            $value = $value ?? 'N/A';

            if (is_numeric($value)) {
                $value = number_format($value, 3);
            }

            $summary[$key] = [
                'title' => str_replace('_', ' ', Str::title($key)),
                'value' => $value,
                'type' => $type
            ];
        }

        return $summary;
    }

    public function getSectiorAllocationData()
    {
        $investments = DB::connection('pgsql-xbrl')
            ->table('mutual_fund_industry_summary')
            ->where($this->fundPrimaryKey())
            ->groupBy('date')
            ->select(DB::raw('SUM(weight) as weight'), 'date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                $date = Carbon::parse($item->date);
                return [
                    'date' => $item->date,
                    'quarter' => "Q{$date->quarter}-{$date->year}",
                    'weight' => number_format($item->weight, 2),
                ];
            });

        $lastQuarterSectorAllocation = collect([]);
        if ($investments->count()) {
            $latestDate = $investments->last()['date'];

            $lastQuarterSectorAllocation = DB::connection('pgsql-xbrl')
                ->table('mutual_fund_industry_summary')
                ->where($this->fundPrimaryKey())
                ->where('date', $latestDate)
                ->select('industry_title', 'weight')
                ->orderBy('weight', 'desc')
                ->limit(15)
                ->get()
                ->map(function ($item) {
                    return [
                        'name' => Str::title($item->industry_title),
                        'weight' => number_format($item->weight, 2),
                        'conversionRate' => number_format($item->weight, 2),
                    ];
                });
        }

        return [
            'overTimeSectorAllocation' => $investments->toArray(),
            'lastQuarterSectorAllocation' => $lastQuarterSectorAllocation?->toArray(),
            'conversionRate' => $lastQuarterSectorAllocation->count()
                ? number_format($lastQuarterSectorAllocation->sum('conversionRate') / $lastQuarterSectorAllocation->count(), 2)
                : 0,
            'sectorAllocationChangePercentage' => $investments->count() < 2
                ? 0
                : number_format($investments->last()['weight'] - $investments->first()['weight']),
        ];
    }

    public function getHoldingSummary()
    {
        return DB::connection('pgsql-xbrl')
            ->table('mutual_fund_holdings')
            ->select('weight', 'symbol', 'name')
            ->where($this->fundPrimaryKey())
            ->where('period_of_report', $this->quarter)
            ->orderByDesc('weight')
            ->limit(7)
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->name . ' (' . $item->symbol . ')',
                    'weight' => number_format($item->weight, 2),
                ];
            })
            ->toArray();
    }

    public function getOverTimeMarketValue()
    {
        $totalValues = DB::connection('pgsql-xbrl')
            ->table('mutual_fund_holdings_summary')
            ->where($this->fundPrimaryKey())
            ->select('date', 'total_value')
            ->orderBy('date')
            ->get();

        $chartData = [];

        foreach ($totalValues as $value) {
            $date = Carbon::parse($value->date);

            $chartData[] = [
                'date' => $value->date,
                'quarter' => "Q{$date->quarter}-{$date->year}",
                'total' => $value->total_value
            ];
        }

        $this->emit('overTimeMarketValue', $chartData);

        return $chartData;
    }

    public function getTopBuySells()
    {
        $topBuys = DB::connection('pgsql-xbrl')
            ->table('mutual_fund_holdings')
            ->select('change_in_balance', 'symbol', 'name')
            ->where($this->fundPrimaryKey())
            ->where('period_of_report', $this->quarter)
            ->orderByDesc('change_in_balance')
            ->where('change_in_balance', '>', 0)
            ->limit(10)
            ->get()
            ->map(function ($item) {
                $item->name = Str::title($item->name);
                return $item;
            });

        $max = $topBuys->max('change_in_balance');
        $min = $topBuys->min('change_in_balance');

        $topBuys = $topBuys->map(function ($item) use ($max, $min) {
            $item->width = ((($item->change_in_balance - $min) / ($max - $min)) * 80) + 10;
            return $item;
        });

        $topSells = DB::connection('pgsql-xbrl')
            ->table('mutual_fund_holdings')
            ->select('change_in_balance', 'symbol', 'name')
            ->where($this->fundPrimaryKey())
            ->where('period_of_report', $this->quarter)
            ->orderBy('change_in_balance')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                $item->name = Str::title($item->name);
                return $item;
            });

        $max = $topSells->max('change_in_balance');
        $min = $topSells->min('change_in_balance');

        $topSells = $topSells->map(function ($item) use ($max, $min) {
            $item->width = 90 - (($item->change_in_balance - $min) / ($max - $min)) * 80;
            return $item;
        });

        return [
            'topBuys' => $topBuys,
            'topSells' => $topSells
        ];
    }

    private function getLatestQuarter(): string
    {
        return DB::connection('pgsql-xbrl')
            ->table('mutual_fund_holdings_summary')
            ->where($this->fundPrimaryKey())
            ->max('date');
    }

    private function fundPrimaryKey()
    {
        return [
            'fund_symbol' => $this->fund['fund_symbol'],
            'cik' => $this->fund['cik'],
            'series_id' => $this->fund['series_id'],
            'class_id' => $this->fund['class_id'],
        ];
    }
}
