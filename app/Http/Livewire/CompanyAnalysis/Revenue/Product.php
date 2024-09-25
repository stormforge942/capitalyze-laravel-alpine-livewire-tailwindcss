<?php

namespace App\Http\Livewire\CompanyAnalysis\Revenue;

use App\Http\Livewire\CompanyAnalysis\HasFilters;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class Product extends Component
{
    use HasFilters;

    public $company;
    public $rawData = [];
    public $publicView;
    public $chartConfig = [
        'showLabel' => false,
        'type' => 'values',
    ];

    public function mount()
    {
        $data = $this->getData();

        $this->extractDates($data);

        $this->formatData($data);

        $this->publicView = data_get(Auth::user(), 'settings.publicView', true);
    }

    public function updated($prop)
    {
        if (in_array($prop, ['period'])) {
            $data = $this->getData();

            $this->extractDates($data);

            $this->formatData($data);
        }
    }

    public function render()
    {
        return view('livewire.company-analysis.revenue.product', [
            'data' => $this->makeData(),
            'chart' => [
                'data' => $this->makeChartData(),
                'key' => $this->makeChartKey(),
            ],
        ]);
    }

    private function makeChartData()
    {
        $data = $this->rawData;

        $dataset = [];

        foreach (array_keys($data['products']) as $idx => $product) {
            $values = $data['products'][$product];
            $bg = $this->chartColors[$idx] ?? random_color();

            $dataset[] = [
                'label' => $product,
                'data' => array_map(fn ($date) => [
                    'x' => $this->formatDateForChart($date),
                    'value' => $values['timeline'][$date],
                    'percent' => round($values['total_percent'][$date], $this->decimalPlaces),
                ], $this->selectedDates),
                "borderRadius" => 2,
                "fill" => true,
                "backgroundColor" => $bg,
                "datalabels" => ['color' => '#fff'],
            ];
        }

        return $dataset;
    }

    private function makeData()
    {
        $this->updateSelectedDates();

        $result = $this->rawData;

        // lets update the result with correct unit and decimals
        foreach ($result['products'] as $product => $values) {
            foreach ($values as $key => $value) {
                if (in_array($key, ['hash', 'secondHash', 'formulas'])) {
                    continue;
                }

                foreach ($value as $date => $amt) {
                    $result['products'][$product][$key][$date] = [
                        'value' => $amt,
                        'formatted' => in_array($key, ['yoy_change', 'total_percent'])
                            ? $this->formatPercentageValue($amt)
                            : $this->formatValue($amt),
                    ];
                }
            }
        }

        foreach ($result['total'] as $key => $value) {
            if (in_array($key, ['formulas'])) {
                continue;
            }

            foreach ($value as $date => $amt) {
                $result['total'][$key][$date] = [
                    'value' => $amt,
                    'formatted' => in_array($key, ['yoy_change', 'total_percent'])
                        ? $this->formatPercentageValue($amt)
                        : $this->formatValue($amt),
                ];
            }
        }

        return $result;
    }

    private function formatData($products)
    {
        $data = [
            'products' => tap([], function (&$val) use ($products) {
                foreach ($products as $product => $_) {
                    $val[$product] = [
                        'timeline' => [],
                        'yoy_change' => [],
                        'total_percent' => [],
                    ];
                }
            }),
            'total' => [
                'timeline' => array_reduce($this->dates, function ($acc, $date) {
                    $acc[$date] = 0;
                    return $acc;
                }, []),
                'yoy_change' => [],
            ],
        ];

        foreach ($products as $product => $timeline) {
            $lastVal = 0;

            foreach ($this->dates as $date) {
                $value = $timeline[$date]['value'] ?? 0;

                $data['products'][$product]['timeline'][$date] = $value;
                $data['products'][$product]['yoy_change'][$date] = $lastVal
                    ? (($value / $lastVal) - 1) * 100
                    : 0;

                $data['total']['timeline'][$date] += $value;

                $data['products'][$product]['hash'][$date] =  $timeline[$date]['hash'] ?? null;
                $data['products'][$product]['secondHash'][$date] = $timeline[$date]['secondHash'] ?? null;
                $data['products'][$product]['formulas']['yoy_change'][$date] = $this->makeFormulaDescription([$value, $lastVal], $data['products'][$product]['yoy_change'][$date], $date, 'Total Revenue', 'yoy_change');

                $lastVal = $value;
            }
        }

        $lastTotal = 0;
        foreach ($this->dates as $date) {
            $total = $data['total']['timeline'][$date];

            $data['total']['yoy_change'][$date] = $lastTotal
                ? (($total / $lastTotal) - 1) * 100
                : 0;

            $data['total']['formulas'][$date] = $this->makeFormulaDescription([$total, $lastTotal], $data['total']['yoy_change'][$date], $date, 'Total Revenue', 'yoy_change');

            $lastTotal = $total;

            foreach ($data['products'] as $product => $_) {
                $data['products'][$product]['total_percent'][$date] = ($data['products'][$product]['timeline'][$date] / $total) * 100;
                $data['products'][$product]['formulas']['total_percent'][$date] = $this->makeFormulaDescription([$data['products'][$product]['timeline'][$date], $total], $data['products'][$product]['total_percent'][$date], $date, 'Product Revenue', 'of_total_revenue');
            }
        }

        $this->rawData = $data;
    }

    private function getData()
    {
        $source = ($this->period == 'annual') ? 'arps' : 'qrps';

        $cacheKey = 'sec_segmentation_' . $this->company['ticker'] . '_' . $source;

        $cacheDuration = 3600;

        $periodMap = ['annual' => 'annual', 'quarterly' => 'quarter'];

        $data = Cache::remember($cacheKey, $cacheDuration, function () use ($source, $periodMap) {
            return rescue(fn () =>
                DB::connection('pgsql-xbrl')
                    ->table('as_reported_sec_segmentation_api')
                    ->join('info_tikr_presentations', 'as_reported_sec_segmentation_api.ticker', '=', 'info_tikr_presentations.ticker')
                    ->where('as_reported_sec_segmentation_api.ticker', '=', $this->company['ticker'])
                    ->where('as_reported_sec_segmentation_api.endpoint', '=', $source)
                    ->where('info_tikr_presentations.period', '=', $periodMap[$this->period])
                    ->select('as_reported_sec_segmentation_api.api_return_open_ai', 'info_tikr_presentations.income_statement')
                    ->first()
                );
        });

        $products = [];
        $apiReturns = json_decode($data->api_return_open_ai, true);
        $incomeStatements = collect(json_decode($data->income_statement, true));
        $revenueKey = $incomeStatements->search(function ($value, $key) {
            return str_contains($key, 'Revenue');
        });

        foreach ($apiReturns as $item) {
            $date = array_key_first($item);

            foreach ($item[$date] as $key => $value) {
                $name = str_replace(' [Member]', '', $key);

                if (!isset($products[$name])) {
                    $products[$name] = [];
                }

                $hashExtractionResult = $this->extractHashes($incomeStatements[$revenueKey][$date]);

                $products[$name][$date] = ['value' => intval($value), 'hash' => $hashExtractionResult['hash'], 'secondHash' => $hashExtractionResult['secondHash']];
            }
        }

        return $products;
    }

    private function extractDates($data)
    {
        if (!count($data)) {
            $this->dates = [];
            return;
        }

        $dates = array_keys(last($data) ?? []);

        $this->selectDates($dates);
    }

    private function extractHashes($data)
    {
        list($value, $hash, $secondHash) = array_pad(explode('|', $data[0]), 3, null);

        return [
          'value' => $value,
          'hash' => $hash,
          'secondHash' => $secondHash,
        ];
    }

    private function makeFormulaDescription($arguments, $result, $date, $metric, $type)
    {
        $value = makeFormulaDescription($arguments, $result, $date, $metric, $type);
        $value['body']['value_final'] = $this->formatPercentageValue($result);

        return $value;
    }
}
