<?php

namespace App\Http\Livewire\CompanyAnalysis\Revenue;

use App\Http\Livewire\CompanyAnalysis\HasFilters;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Product extends Component
{
    use HasFilters;

    public $company;
    public $rawData = [];
    public $chartConfig = [
        'showLabel' => true,
        'type' => 'values',
    ];

    public function mount()
    {
        $data = $this->getData();

        $this->extractDates($data);

        $this->formatData($data);
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
                    'percent' => round($values['total_percent'][$date], 2),
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
                $value = $timeline[$date] ?? 0;

                $data['products'][$product]['timeline'][$date] = $value;
                $data['products'][$product]['yoy_change'][$date] = $lastVal
                    ? (($value / $lastVal) - 1) * 100
                    : 0;

                $data['total']['timeline'][$date] += $value;

                $lastVal = $value;
            }
        }

        $lastTotal = 0;
        foreach ($this->dates as $date) {
            $total = $data['total']['timeline'][$date];

            $data['total']['yoy_change'][$date] = $lastTotal
                ? (($total / $lastTotal) - 1) * 100
                : 0;

            $lastTotal = $total;

            foreach ($data['products'] as $product => $_) {
                $data['products'][$product]['total_percent'][$date] = ($data['products'][$product]['timeline'][$date] / $total) * 100;
            }
        }

        $this->rawData = $data;
    }

    private function getData()
    {
        $source = ($this->period == 'annual') ? 'arps' : 'qrps';

        $data = rescue(fn () => json_decode(DB::connection('pgsql-xbrl')
            ->table('as_reported_sec_segmentation_api')
            ->where('ticker', '=', $this->company['ticker'])
            ->where('endpoint', '=', $source)
            ->value('api_return_open_ai'), true), [], false);

        $products = [];

        foreach ($data as $item) {
            $date = array_key_first($item);

            foreach ($item[$date] as $key => $value) {
                $name = str_replace(' [Member]', '', $key);

                if (!isset($products[$name])) {
                    $products[$name] = [];
                }

                $products[$name][$date] = intval($value);
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
}
