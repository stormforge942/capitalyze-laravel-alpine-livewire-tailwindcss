<?php

namespace App\Http\Livewire\Ownership;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Http\Livewire\AsTab;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class FundSummary extends Component
{
    use AsTab;

    public string $quarter = '';
    public $cik;

    public static function title(): string
    {
        return 'Summary';
    }

    public function mount(array $data)
    {
        $this->cik = $data['fund']['cik'];

        $this->quarter = $this->getLatestQuarter();
    }

    public function render()
    {
        return view('livewire.ownership.fund-summary', [
            'summary' => $this->getSummary(),
        ]);
    }

    public function getSummary()
    {
        $summary = (array) DB::connection('pgsql-xbrl')
            ->table('filings_summary')
            ->select('cik', 'investor_name', 'portfolio_size', 'added_securities', 'removed_securities', 'total_value', 'last_value', 'change_in_total_value', 'change_in_total_value_percentage', 'turnover', 'turnover_alt_sell', 'turnover_alt_buy', 'average_holding_period', 'average_holding_period_top10', 'average_holding_period_top20', 'url')
            ->where('cik', '=', $this->cik)
            ->where('date', '=', $this->quarter)
            ->first() ?? [];

        $percentageFields = [
            'change_in_total_value_percentage',
            'turnover',
            'turnover_alt_sell',
            'turnover_alt_buy'
        ];

        foreach ($summary as $key => $value) {
            if (in_array($key, $percentageFields)) {
                $value = number_format($value, 2) . ' %';
            }

            $type = Str::startsWith($value, 'https') ? 'link' : 'text';

            if ($key === 'url') {
                $value = getSiteNameFromUrl($value);
            }

            $summary[$key] = [
                'title' => str_replace('Percentage', '%', str_replace('_', ' ', Str::title($key))),
                'value' => $value ?? 'N/A',
                'type' => $type
            ];
        }

        return $summary;
    }

    public function getSectorAllocationData()
    {
        $investments = [];

        DB::connection('pgsql-xbrl')
            ->table('industry_summary')
            ->where('cik', '=', $this->cik)
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

        $last = end($investments) ?: [];
        $last = collect($last)->where('industry', '!=', 'Other')->sortByDesc('weight')->take(25);
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
            ->table('filings')
            ->select('weight', 'symbol', 'name_of_issuer')
            ->where('cik', '=', $this->cik)
            ->where('report_calendar_or_quarter', '=', $this->quarter)
            ->orderByDesc('weight')
            ->limit(7)
            ->get()
            ->map(function ($item) {
                return [
                    'name' => Str::title($item->name_of_issuer) . ($item->symbol ? " ({$item->symbol})" : ''),
                    'weight' => number_format($item->weight, 2),
                ];
            })
            ->toArray();
    }

    public function getOverTimeMarketValue()
    {
        $totalValues = DB::connection('pgsql-xbrl')
            ->table('filings_summary')
            ->where('cik', '=', $this->cik)
            ->select('date', 'total_value')
            ->orderBy('total_value')
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
            ->table('filings')
            ->select('change_in_shares', 'change_in_value', 'symbol', 'name_of_issuer')
            ->where('cik', '=', $this->cik)
            ->where('report_calendar_or_quarter', '=', $this->quarter)
            ->orderByDesc('change_in_shares')
            ->where('change_in_shares', '>', 0)
            ->limit(10)
            ->get()
            ->map(function ($item) {
                $item->name_of_issuer = Str::title($item->name_of_issuer);
                return $item;
            });

        $max = $topBuys->max('change_in_shares');
        $min = $topBuys->min('change_in_shares');

        $topBuys = $topBuys->map(function ($item) use ($max, $min) {
            $item->width = ((($item->change_in_shares - $min) / ($max - $min)) * 80) + 10;
            return $item;
        });

        $topSells = DB::connection('pgsql-xbrl')
            ->table('filings')
            ->select('change_in_shares', 'change_in_value', 'symbol', 'name_of_issuer')
            ->where('cik', '=', $this->cik)
            ->where('report_calendar_or_quarter', '=', $this->quarter)
            ->orderBy('change_in_shares')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                $item->name_of_issuer = Str::title($item->name_of_issuer);
                return $item;
            });

        $max = $topSells->max('change_in_shares');
        $min = $topSells->min('change_in_shares');

        $topSells = $topSells->map(function ($item) use ($max, $min) {
            $item->width = 90 - (($item->change_in_shares - $min) / ($max - $min)) * 80;
            return $item;
        });

        return [
            'topBuys' => $topBuys,
            'topSells' => $topSells
        ];
    }

    private function getLatestQuarter()
    {
        $latestFiling = Carbon::parse(DB::connection('pgsql-xbrl')
            ->table('filings_summary')
            ->where('cik', '=', $this->cik)
            ->max('date'));

        if (!$latestFiling) {
            throw new \Exception('No filings found for this fund');
        }

        $quarterEnd = [
            1 => 31,
            2 => 30,
            3 => 30,
            4 => 31,
        ];

        $year = $latestFiling->year;
        $quarter = $latestFiling->quarter;

        $currentYear = now()->year;
        $currentQuarter = now()->quarter;
        $currentDay = now()->day;

        // Don't include the current quarter if it's not over yet
        if (
            $year == $currentYear &&
            $quarter == $currentQuarter &&
            $currentDay < $quarterEnd[$quarter]
        ) {
            // If it's the first quarter, go back to the previous year
            if ($quarter == 1) {
                $year--;
                $quarter = 4;
            } else {
                $quarter--;
            }
        }

        return "$year-" . str_pad(($quarter * 3), 2, "0", STR_PAD_LEFT) . "-{$quarterEnd[$quarter]}";
    }
}
