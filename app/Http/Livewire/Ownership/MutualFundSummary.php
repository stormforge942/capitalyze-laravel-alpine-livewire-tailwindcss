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
    public $latestDate = '';

    public static function title(): string
    {
        return 'Summary';
    }

    public function mount(array $data)
    {
        $this->fund = $data['fund'];
        $this->latestDate = $this->getLatestDate();
    }

    public function render()
    {
        return view('livewire.ownership.mutual-fund-summary', [
            'summary' => $this->getSummary(),
        ]);
    }

    public function getSummary()
    {
        $summary = (array) DB::connection('pgsql-xbrl')
            ->table('mutual_fund_holdings_summary')
            ->select('cik', 'series_id', 'class_id',  'registrant_name', 'portfolio_size', 'added_securities', 'removed_securities', 'total_value', 'previous_value', 'change_in_total_value', 'change_in_total_value_percentage', 'turnover', 'turnover_alt_sell', 'turnover_alt_buy', 'average_holding_period', 'average_holding_period_top10', 'average_holding_period_top20')
            ->where($this->fundPrimaryKey())
            ->where('date', $this->latestDate)
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

    public function getSectorAllocationData()
    {
        $investments = [];

        DB::connection('pgsql-xbrl')
            ->table('mutual_fund_industry_summary')
            ->where($this->fundPrimaryKey())
            ->select('industry_title', 'weight', 'date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) use (&$investments) {
                $date = Carbon::parse($item->date);
                $key = "Q{$date->quarter}-{$date->year}";

                if (!isset($investments[$key])) {
                    $investments[$key] = [];
                }

                $investments[$key][] = [
                    'industry' => Str::title($item->industry_title),
                    'weight' => floatval($item->weight),
                    'quarter' => $key,
                ];
            });

        $last = collect(end($investments) ?? [])
            ->where('industry', '!=', 'Other')
            ->sortByDesc('weight')
            ->take(25);

        $weight = $last->sum('weight');
        if ($weight < 100) {
            $last[] = [
                'industry' => 'Other',
                'weight' => 100 - $weight,
            ];
        }
        $last = $last->values()->toArray();

        $data = [];
        foreach ($investments as $key => $value) {
            $top10 = collect($value)->where('industry', '!=', 'Other')->sortByDesc('weight')->take(10);
            $data = array_merge($data, $top10->values()->toArray());

            $weight = $top10->sum('weight');

            if ($weight < 100) {
                $data[] = [
                    'industry' => 'Other',
                    'weight' => 100 - $weight,
                    'quarter' => $key,
                ];
            }
        }

        $data = collect($data)->groupBy('industry')->toArray();

        $datasetOverTime = [];
        $colors = config('capitalyze.chartColors');

        foreach (array_keys($data) as $idx => $label) {
            $_data = $data[$label];

            $datasetOverTime[] = [
                'label' => $label,
                'data' => array_map(
                    fn ($item) => [
                        'x' => $item['quarter'],
                        'y' => $item['weight'],
                    ],
                    $_data
                ),
                'backgroundColor' => $colors[$idx] ?? random_color(),
            ];
        }

        $datasetLastQuarter = [
            'data' => [],
            'labels' => [],
            'backgroundColors' => [],
        ];

        foreach ($last as $idx => $item) {
            $datasetLastQuarter['labels'][] = $item['industry'];
            $datasetLastQuarter['data'][] = $item['weight'];
            $datasetLastQuarter['backgroundColors'][] = $colors[$idx] ?? random_color();
        }

        return [
            'overTimeSectorAllocation' => $datasetOverTime,
            'lastQuarterSectorAllocation' => $datasetLastQuarter,
        ];
    }

    public function getHoldingSummary()
    {
        return DB::connection('pgsql-xbrl')
            ->table('mutual_fund_holdings')
            ->select('weight', 'symbol', 'name')
            ->where($this->fundPrimaryKey())
            ->where('period_of_report', $this->latestDate)
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
            ->select('change_in_balance', 'name')
            ->where($this->fundPrimaryKey())
            ->where('period_of_report', $this->latestDate)
            ->orderByDesc('change_in_balance')
            ->where('change_in_balance', '>', 0)
            ->limit(10)
            ->get()
            ->map(function ($item) {
                $item->key = Str::random(10);
                $item->name = $item->name;
                return $item;
            });

        $max = $topBuys->max('change_in_balance');
        $min = $topBuys->min('change_in_balance');

        $topBuys = $topBuys->map(function ($item) use ($max, $min) {
            $diff = $max - $min;

            $item->width = $diff == 0 ? 0 : ((($item->change_in_balance - $min) / $diff) * 80) + 10;

            return $item;
        });

        $topSells = DB::connection('pgsql-xbrl')
            ->table('mutual_fund_holdings')
            ->select('change_in_balance', 'name')
            ->where($this->fundPrimaryKey())
            ->where('period_of_report', $this->latestDate)
            ->orderBy('change_in_balance')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                $item->key = Str::random(10);
                $item->name = $item->name;
                return $item;
            });

        $max = $topSells->max('change_in_balance');
        $min = $topSells->min('change_in_balance');

        $topSells = $topSells->map(function ($item) use ($max, $min) {
            $diff = $max - $min;

            $item->width = $diff == 0 ? 0 : ((($item->change_in_balance - $min) / $diff) * 80) + 10;

            return $item;
        });

        return [
            'topBuys' => $topBuys,
            'topSells' => $topSells
        ];
    }

    private function getLatestDate(): string
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
            'class_name' => $this->fund['class_name'],
        ];
    }
}
