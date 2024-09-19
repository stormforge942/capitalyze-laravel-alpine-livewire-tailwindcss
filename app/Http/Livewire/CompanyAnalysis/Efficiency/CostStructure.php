<?php

namespace App\Http\Livewire\CompanyAnalysis\Efficiency;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Http\Livewire\CompanyAnalysis\HasFilters;

class CostStructure extends Component
{
    use HasFilters;

    public $company;
    public $statements;
    public $rawData = [];
    public $publicView;
    public $chartConfig = [
        'showLabel' => false,
        'type' => 'values',
    ];

    public function mount()
    {
        $this->extractDates();

        $this->formatData();

        $this->publicView = data_get(Auth::user(), 'settings.publicView', true);
    }

    public function updated($prop)
    {
        if (in_array($prop, ['period'])) {
            $this->extractDates();
            $this->formatData();
        }
    }

    public function render()
    {
        return view('livewire.company-analysis.efficiency.cost-structure', [
            'data' => $this->makeData(),
            'chart' => [
                'data' => $this->makeChartData(),
                'key' => $this->makeChartKey(),
            ]
        ]);
    }

    private function makeChartData(): array
    {
        $data = $this->rawData;

        $dataset = [];

        $labelMap = [
            'Cost of Goods Sold' => 'COGS',
            'R&D Expenses' => 'R&D',
            'SG&A Expenses' => 'SG&A',
        ];

        foreach ($data['segments'] as $idx => $segment) {
            $bg = $this->chartColors[$idx++ + count($data['segments'])] ?? random_color();

            $dataset[] = [
                'label' => $labelMap[$segment['title']] . ' as % of Revenue',
                'data' => array_map(fn ($date) => [
                    'x' => $this->formatDateForChart($date),
                    'y' => round($segment['revenue_percentage'][$date], $this->decimalPlaces),
                ], $this->selectedDates),
                "fill" => false,
                "backgroundColor" => $bg,
                "borderColor" => $bg,
                "type" => "line",
                'yAxisID' => 'y1',
                'pointRadius' => 0,
                'dataType' => 'percentage',
            ];
        }

        $idx = 0;
        foreach ($data['segments'] as $idx => $segment) {
            $bg = $this->chartColors[$idx++] ?? random_color();

            $dataset[] = [
                'label' => $labelMap[$segment['title']],
                'data' => array_map(fn ($date) => [
                    'x' => $this->formatDateForChart($date),
                    'value' => $segment['timeline'][$date],
                    'percent' => round($segment['expense_percentage'][$date], $this->decimalPlaces),
                ], $this->selectedDates),
                "borderRadius" => 2,
                "fill" => true,
                "backgroundColor" => $bg,
            ];
        }

        return $dataset;
    }

    private function formatData()
    {
        $statement = $this->statements[$this->period]['income_statement'];

        $data = [
            'segments' => [],
            'total_expenses' => [
                'timeline' => array_reduce(
                    $this->dates,
                    function ($carry, $date) use ($statement) {
                        $cgs = isset($statement['Cost of Goods Sold'][$date]) ? abs($this->extractValues($statement['Cost of Goods Sold'][$date])['value']) : 0;
                        $rde = isset($statement['R&D Expenses'][$date]) ? abs($this->extractValues($statement['R&D Expenses'][$date])['value']) : 0;
                        $sge = isset($statement['SG&A Expenses'][$date]) ? abs($this->extractValues($statement['SG&A Expenses'][$date])['value']) : 0;

                        $carry[$date] =  $cgs + $rde + $sge;

                        return $carry;
                    },
                    []
                ),
                'hash' => array_combine($this->dates, array_map(fn ($date) => $this->extractValues($statement['Total Operating Expenses'][$date])['hash'] ?? 0, $this->dates)),
                'secondHash' => array_combine($this->dates, array_map(fn ($date) => $this->extractValues($statement['Total Operating Expenses'][$date])['secondHash'] ?? 0, $this->dates)),
                'yoy_change' => [],
                'revenue_percentage' => [],
            ],
            'revenues' => [
                'timeline' => array_combine($this->dates, array_map(fn ($date) => $this->extractValues($statement['Total Revenues'][$date])['value'] ?? 0, $this->dates)),
                'hash' => array_combine($this->dates, array_map(fn ($date) => $this->extractValues($statement['Total Revenues'][$date])['hash'], $this->dates)),
                'secondHash' => array_combine($this->dates, array_map(fn ($date) => $this->extractValues($statement['Total Revenues'][$date])['secondHash'], $this->dates)),
                'yoy_change' => [],
            ],
            'formulas' => []
        ];

        // update yoy change
        foreach (['total_expenses', 'revenues'] as $key) {
            $lastValue = 0;
            $formulasLabelMap = [
                'total_expenses' => 'Total Expenses',
                'revenues' => 'Revenues',
            ];

            foreach ($this->dates as $idx => $date) {
                $value = $data[$key]['timeline'][$date];

                $data[$key]['yoy_change'][$date] = $lastValue && $idx
                    ? (($value / $lastValue) - 1) * 100
                    : 0;

                $data['formulas'][$key]['yoy_change'][$date] = $this->makeFormulaDescription($value, $lastValue, $data[$key]['yoy_change'][$date], $date, $formulasLabelMap[$key]);

                $lastValue = $value;
            }
        }

        // calculate expenses revenue percentage
        foreach ($this->dates as $date) {
            $data['total_expenses']['revenue_percentage'][$date] = $data['total_expenses']['timeline'][$date] / $data['revenues']['timeline'][$date] * 100;
        }

        $segments = [
            [
                'title' => 'Cost of Goods Sold',
                'key' => 'Cost of Goods Sold',
            ],
            [
                'title' => 'R&D Expenses',
                'key' => 'R&D Expenses',
            ],
            [
                'title' => 'SG&A Expenses',
                'key' => 'SG&A Expenses',
            ],
        ];

        foreach ($segments as $seg) {
            $segment = [
                'title' => $seg['title'],
                'timeline' => [],
                'yoy_change' => [],
                'revenue_percentage' => [],
                'expense_percentage' => [],
            ];

            $lastValue = 0;
            foreach ($this->dates as $idx => $date) {
                $value = isset($statement[$seg['key']][$date]) ? abs($this->extractValues($statement[$seg['key']][$date])['value']) : 0;

                $segment['timeline'][$date] = $value;

                $segment['hash'][$date] = isset($statement[$seg['key']][$date]) ? $this->extractValues($statement[$seg['key']][$date])['hash'] : null;
                $segment['secondHash'][$date] = isset($statement[$seg['key']][$date]) ? $this->extractValues($statement[$seg['key']][$date])['secondHash'] : null;

                $segment['yoy_change'][$date] = $lastValue && $idx
                    ? (($value / $lastValue) - 1) * 100
                    : 0;

                $segment['revenue_percentage'][$date] = $value / ($this->extractValues($statement['Total Revenues'][$date])['value'] ?? 0) * 100;
                $segment['expense_percentage'][$date] = $value / $this->extractValues($data['total_expenses']['timeline'][$date])['value'] * 100;

                $data['formulas'][$segment['title']]['yoy_change'][$date] = $this->makeFormulaDescription($value, $lastValue, $segment['yoy_change'][$date], $date, $segment['title']);

                $lastValue = $value;
            }

            $data['segments'][] = $segment;
        }

        $this->rawData = $data;
    }

    private function extractDates()
    {
        $dates = [];

        foreach ($this->statements[$this->period]['income_statement'] as $values) {
            foreach ($values as $date => $_) {
                if (!in_array($date, $dates)) {
                    $dates[] = $date;
                }
            }
        }

        $this->selectDates($dates);
    }

    private function makeData()
    {
        $this->updateSelectedDates();

        $data = $this->rawData;

        foreach ($data['segments'] as $idx => $segment) {
            $data['segments'][$idx]['timeline'] = array_map(fn ($value) => [
                'value' => $value,
                'formatted' => $this->formatValue($value),
            ], $segment['timeline']);

            foreach (['yoy_change', 'revenue_percentage', 'expense_percentage'] as $key) {
                $data['segments'][$idx][$key] = array_map(fn ($value) => [
                    'value' => $value,
                    'formatted' => $this->formatPercentageValue($value),
                ], $segment[$key]);
            }
        }

        foreach (['total_expenses', 'revenues'] as $key) {
            $data[$key]['timeline'] = array_map(fn ($value) => [
                'value' => $value,
                'formatted' => $this->formatValue($value),
            ], $data[$key]['timeline']);

            if ($key == 'total_expenses') {
                $data[$key]['revenue_percentage'] = array_map(
                    fn ($value) => [
                        'value' => $value,
                        'formatted' => $this->formatPercentageValue($value),
                    ],
                    $data[$key]['revenue_percentage']
                );
            }

            $data[$key]['yoy_change'] = array_map(fn ($value) => [
                'value' => $value,
                'formatted' => $this->formatPercentageValue($value),
            ], $data[$key]['yoy_change']);
        }

        return $data;
    }

    private function extractValues($value)
    {
        list($extractedValue, $hash, $secondHash) = array_pad(explode("|", $value ?? ""), 3, null);

        return [
            'value' => intval($extractedValue),
            'hash' => $hash,
            'secondHash' => $secondHash,
        ];
    }

    private function makeFormulaDescription($firstValue, $secondValue, $result, $date, $metric)
    {
        $value = makeFormulaDescription($firstValue, $secondValue, $result, $date, $metric);
        $value['body']['value_final'] = $this->formatPercentageValue($result);

        return $value;
    }
}
