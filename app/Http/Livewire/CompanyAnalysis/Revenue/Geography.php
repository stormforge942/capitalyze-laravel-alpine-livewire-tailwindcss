<?php

namespace App\Http\Livewire\CompanyAnalysis\Revenue;

use App\Http\Livewire\CompanyAnalysis\HasFilters;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class Geography extends Component
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
        return view('livewire.company-analysis.revenue.geography', [
            'data' => $this->makeData(),
            'chart' => [
                'data' => $this->makeChartData(),
                'key' => $this->makeChartKey(),
            ]
        ]);
    }

    private function makeChartData()
    {
        $this->updateSelectedDates();

        $data = $this->rawData;

        $dataset = [];

        foreach (array_keys($data['regions']) as $idx => $region) {
            $values = $data['regions'][$region];
            $bg = $this->chartColors[$idx] ?? random_color();

            $dataset[] = [
                'label' => $region,
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

        foreach ($result['regions'] as $region => $values) {
            foreach ($values as $key => $value) {
                foreach ($value as $date => $amt) {
                    $result['regions'][$region][$key][$date] = [
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

    private function getData()
    {
        $source = ($this->period == 'annual') ? 'args' : 'qrgs';

        $cacheKey = 'sec_segmentation_api_' . $this->company['ticker'] . '_' . $source;

        $cacheDuration = 3600;

        $data = Cache::remember($cacheKey, $cacheDuration, function () use ($source) {
            return rescue(fn () => json_decode(
                DB::connection('pgsql-xbrl')
                    ->table('as_reported_sec_segmentation_api')
                    ->where('ticker', '=', $this->company['ticker'])
                    ->where('endpoint', '=', $source)
                    ->value('api_return_open_ai'), true), [], false);
        });

        $regions = [];

        foreach ($data as $item) {
            $date = array_key_first($item);

            foreach ($item[$date] as $key => $value) {
                $name = str_replace(' [Member]', '', $key);

                if (!isset($regions[$name])) {
                    $regions[$name] = [];
                }

                $regions[$name][$date] = intval($value);
            }
        }

        return $regions;
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

    private function formatData($regions)
    {
        $data = [
            'regions' => tap([], function (&$val) use ($regions) {
                foreach ($regions as $region => $_) {
                    $val[$region] = [
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

        foreach ($regions as $region => $timeline) {
            $lastVal = 0;

            foreach ($this->dates as $date) {
                $value = $timeline[$date] ?? 0;

                $data['regions'][$region]['timeline'][$date] = $value;
                $data['regions'][$region]['yoy_change'][$date] = $lastVal
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
            
            foreach ($data['regions'] as $region => $_) {
                $data['regions'][$region]['total_percent'][$date] = $total != 0 ? ($data['regions'][$region]['timeline'][$date] / $total) * 100 : 0;
            }
        }

        $this->rawData = $data;
    }
}
