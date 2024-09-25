<?php

namespace App\Http\Livewire\CompanyAnalysis\CapitalAllocation;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\InfoTikrPresentation;
use App\Http\Livewire\CompanyAnalysis\HasFilters;

class SourceAndUses extends Component
{
    use HasFilters;

    public $company;
    public $rawData;
    public $publicView;
    public $formulaHashes = [];
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
        return view('livewire.company-analysis.capital-allocation.source-and-uses', [
            'data' => $this->makeData(),
            'chart' => [
                'sources' => [
                    'data' => $this->makeChartData('sources'),
                    'key' => $this->makeChartKey() . ' - Sources',
                ],
                'uses' => [
                    'data' => $this->makeChartData('uses'),
                    'key' => $this->makeChartKey() . ' - Uses',
                ]
            ],
            'formulaHashes' => $this->formulaHashes,
        ]);
    }

    private function makeChartData(string $for)
    {
        $data = $this->rawData[$for];

        $datasets = [];

        $keyTitleMap = $for === 'sources' ? [
            'free_cashflow' => 'Free Cash Flow',
            'net_debt' => 'Total Debt Issued',
            'preferred_stock' => 'Issuance of Preferred Stock',
            'common_stock' => 'Issuance of Common Stock',
        ] : [
            'acquisition' => 'Acquisitions',
            'debt_repaid' => 'Total Debt Repaid',
            'preferred_repurchase' => 'Repurchase of Preferred Stock',
            'common_repurchase' => 'Repurchase of Common Stock',
            'dividends' => 'Total Dividends Paid',
            'other' => 'Cash Build / Other',
        ];

        $idx = 0;
        foreach ($data as $key => $value) {
            if (in_array($key, ['total', 'formulas'])) continue;

            $datasets[] = [
                'label' => $keyTitleMap[$key],
                'data' => array_map(fn ($date) => [
                    'x' => $this->formatDateForChart($date),
                    'value' => $value['timeline'][$date],
                    'percent' => round($value['total_percent'][$date], $this->decimalPlaces),
                ], $this->selectedDates),
                'backgroundColor' => $this->chartColors[$idx] ?? random_color(),
                'borderRadius' => 2,
                'fill' => true,
                "datalabels" => ['color' => '#fff'],
            ];

            $idx++;
        }

        // calculate average for each dataset and add as data to each dataset
        foreach ($datasets as $idx => $dataset) {
            $average = [
                'x' => 'Average',
                'value' => 0,
                'percent' => 0,
            ];

            foreach ($dataset['data'] as $data) {
                $average['value'] += $data['value'];
                $average['percent'] += $data['percent'];
            }

            $average['value'] = round($average['value'] / count($dataset['data']), $this->decimalPlaces);
            $average['percent'] = round($average['percent'] / count($dataset['data']), $this->decimalPlaces);

            $datasets[$idx]['data'][] = $average;
        }

        return $datasets;
    }

    private function makeData()
    {
        $this->updateSelectedDates();

        $data = $this->rawData;

        foreach ($data as &$value) {
            foreach ($value as $key => $row) {
                if ($key === 'formulas') {
                    continue;
                }

                if (isset($row['timeline'])) {
                    $value[$key]['timeline'] = array_map(
                        fn ($val) => ['value' => $val, 'formatted' => $this->formatValue($val)],
                        $row['timeline']
                    );
                }

                if (isset($row['yoy_change'])) {
                    $value[$key]['yoy_change'] = array_map(
                        fn ($val) => ['formatted' => $this->formatPercentageValue($val), 'value' => $val],
                        $row['yoy_change']
                    );
                }

                if (isset($row['total_percent'])) {
                    $value[$key]['total_percent'] = array_map(
                        fn ($val) => ['formatted' => $this->formatPercentageValue($val), 'value' => $val],
                        $row['total_percent']
                    );
                }
            }
        }

        return $data;
    }

    private function formatData($statement)
    {
        $data = [
            'sources' => [
                'free_cashflow' => [
                    'timeline' => [],
                    'total_percent' => [],
                ],
                'net_debt' => [
                    'timeline' => [],
                    'total_percent' => [],
                ],
                'preferred_stock' => [
                    'timeline' => [],
                    'total_percent' => [],
                ],
                'common_stock' => [
                    'timeline' => [],
                    'total_percent' => [],
                ],
                'total' => [
                    'timeline' => [],
                    'yoy_change' => [],
                ],
                'formulas' => [],
            ],
            'uses' => [
                'acquisition' => [
                    'timeline' => [],
                    'total_percent' => [],
                ],
                'debt_repaid' => [
                    'timeline' => [],
                    'total_percent' => [],
                ],
                'preferred_repurchase' => [
                    'timeline' => [],
                    'total_percent' => [],
                ],
                'common_repurchase' => [
                    'timeline' => [],
                    'total_percent' => [],
                ],
                'dividends' => [
                    'timeline' => [],
                    'total_percent' => [],
                ],
                'other' => [
                    'timeline' => [],
                    'total_percent' => [],
                ],
                'total' => [
                    'timeline' => [],
                    'yoy_change' => [],
                ],
                'formulas' => [],
            ],
        ];

        // for sources
        $lastTotal = 0;
        foreach ($this->dates as $idx => $date) {
            $fcf = $statement['Levered Free Cash Flow'][$date] ?? 0;
            $ndi = $statement['Total Debt Issued'][$date] ?? 0;
            $ips = $statement['Total Preferred Equity'][$date] ?? 0;
            $ics = $statement['Issuance of Common Stock'][$date] ?? 0;

            $total = $fcf + $ndi + $ips + $ics;

            $data['sources']['total']['timeline'][$date] = $total;
            $data['sources']['total']['yoy_change'][$date] = $total && $idx
                ? (($total - $lastTotal) / $total * 100)
                : 0;

            $data['sources']['formulas']['total']['value'][$date] = $this->makeFormulaDescription([$fcf, $ndi, $ips, $ics], $total, $date, 'Total Sources of Cash', 'total_source_of_cash');
            $data['sources']['formulas']['total']['yoy_change'][$date] = $this->makeFormulaDescription([$total, $lastTotal], $data['sources']['total']['yoy_change'][$date], $date, 'Total Sources of Cash', 'yoy_change');

            $lastTotal = $total;

            $data['sources']['free_cashflow']['timeline'][$date] = $fcf;
            $data['sources']['free_cashflow']['total_percent'][$date] = $total ? $fcf / $total * 100 : 0;
            $data['sources']['formulas']['free_cashflow']['total_percent'][$date] = $this->makeFormulaDescription([$fcf, $total], $data['sources']['free_cashflow']['total_percent'][$date], $date, 'Levered Free Cash Flow', 'of_total_sources');

            $data['sources']['net_debt']['timeline'][$date] = $ndi;
            $data['sources']['net_debt']['total_percent'][$date] = $total ? $ndi / $total * 100 : 0;
            $data['sources']['formulas']['net_debt']['total_percent'][$date] = $this->makeFormulaDescription([$ndi, $total], $data['sources']['net_debt']['total_percent'][$date], $date, 'Total Debt Issued', 'of_total_sources');

            $data['sources']['preferred_stock']['timeline'][$date] = $ips;
            $data['sources']['preferred_stock']['total_percent'][$date] = $total ? $ips / $total * 100 : 0;
            $data['sources']['formulas']['preferred_stock']['total_percent'][$date] = $this->makeFormulaDescription([$ips, $total], $data['sources']['preferred_stock']['total_percent'][$date], $date, 'Total Preferred Equity', 'of_total_sources');

            $data['sources']['common_stock']['timeline'][$date] = $ics;
            $data['sources']['common_stock']['total_percent'][$date] = $total ? $ics / $total * 100 : 0;
            $data['sources']['formulas']['common_stock']['total_percent'][$date] = $this->makeFormulaDescription([$ics, $total], $data['sources']['common_stock']['total_percent'][$date], $date, 'Issuance of Common Stock', 'of_total_sources');
        }

        // for uses
        foreach ($this->dates as $idx => $date) {
            $total = $data['sources']['total']['timeline'][$date];

            $ca = $statement['Cash Acquisitions'][$date] ?? 0;
            $tbr = $statement['Total Debt Repaid'][$date] ?? 0;
            $rps = $statement['Repurchase of Preferred Stock'][$date] ?? 0;
            $rcs = $statement['Repurchase of Common Stock'][$date] ?? 0;
            $tdp = $statement['Total Dividends Paid'][$date] ?? 0;
            $other = $total - $ca - $tbr - $rps - $rcs - $tdp;

            $data['uses']['formulas']['other']['value'][$date] = $this->makeFormulaDescription([$total, $ca, $tbr, $rps, $rcs, $tdp], $other, $date, 'Cash Build / Other', 'cash_build_other');

            // copy from sources
            $data['uses']['total'] = $data['sources']['total'];
            $data['uses']['formulas']['total'] = $data['sources']['formulas']['total'];

            $data['uses']['acquisition']['timeline'][$date] = $ca;
            $data['uses']['acquisition']['total_percent'][$date] = $total ? $ca / $total * 100 : 0;
            $data['uses']['formulas']['acquisition']['total_percent'][$date] = $this->makeFormulaDescription([$ca, $total], $data['uses']['acquisition']['total_percent'][$date], $date, 'Cash Acquisitions', 'of_total_uses');

            $data['uses']['debt_repaid']['timeline'][$date] = $tbr;
            $data['uses']['debt_repaid']['total_percent'][$date] = $total ? $tbr / $total * 100 : 0;
            $data['uses']['formulas']['debt_repaid']['total_percent'][$date] = $this->makeFormulaDescription([$tbr, $total], $data['uses']['debt_repaid']['total_percent'][$date], $date, 'Total Debt Repaid', 'of_total_uses');

            $data['uses']['preferred_repurchase']['timeline'][$date] = $rps;
            $data['uses']['preferred_repurchase']['total_percent'][$date] = $total ? $rps / $total * 100 : 0;
            $data['uses']['formulas']['preferred_repurchase']['total_percent'][$date] = $this->makeFormulaDescription([$rps, $total], $data['uses']['preferred_repurchase']['total_percent'][$date], $date, 'Repurchase of Preferred Stock', 'of_total_uses');

            $data['uses']['common_repurchase']['timeline'][$date] = $rcs;
            $data['uses']['common_repurchase']['total_percent'][$date] = $total ? $rcs / $total * 100 : 0;
            $data['uses']['formulas']['common_repurchase']['total_percent'][$date] = $this->makeFormulaDescription([$rcs, $total], $data['uses']['common_repurchase']['total_percent'][$date], $date, 'Repurchase of Common Stock', 'of_total_uses');

            $data['uses']['dividends']['timeline'][$date] = $tdp;
            $data['uses']['dividends']['total_percent'][$date] = $total ? $tdp / $total * 100 : 0;
            $data['uses']['formulas']['dividends']['total_percent'][$date] = $this->makeFormulaDescription([$tdp, $total], $data['uses']['dividends']['total_percent'][$date], $date, 'Total Dividends Paid', 'of_total_uses');

            $data['uses']['other']['timeline'][$date] = $other;
            $data['uses']['other']['total_percent'][$date] = $total ? $other / $total * 100 : 0;
            $data['uses']['formulas']['other']['total_percent'][$date] = $this->makeFormulaDescription([$other, $total], $data['uses']['other']['total_percent'][$date], $date, 'Cash Build / Other', 'of_total_uses');
        }

        $this->rawData = $data;
    }

    private function extractDates($data)
    {
        $dates = [];

        foreach ($data as $values) {
            foreach ($values as $date => $_) {
                if (!in_array($date, $dates)) {
                    $dates[] = $date;
                }
            }
        }

        $this->selectDates($dates);
    }

    private function getData()
    {
        $period = $this->period == 'annual' ? 'annual' : 'quarter';

        $data = rescue(fn () => json_decode(
            InfoTikrPresentation::query()
                ->where('ticker', $this->company['ticker'])
                ->where("period",  $period)
                ->value('cash_flow'),
            true
        ), false);

        $usedKeys = [
            'Levered Free Cash Flow' => 'free_cashflow',
            'Total Debt Issued' => 'net_debt',
            'Issuance of Preferred Stock' => 'preferred_stock',
            'Issuance of Common Stock' => 'common_stock',
            'Cash Acquisitions' => 'acquisition',
            'Total Debt Repaid' => 'debt_repaid',
            'Repurchase of Preferred Stock' => 'preferred_stock',
            'Repurchase of Common Stock' => 'common_stock',
            'Total Dividends Paid' => 'dividends',
        ];

        $valueFormatter = fn ($value) => array_map(fn ($val) => intval(explode("|", $val[0] ?? "")[0]), $value);

        $tmp = [];

        foreach ($data as $key => $value) {
            $key = explode("|", $key)[0];

            if (!in_array($key, array_keys($usedKeys))) continue;

            if (in_array($key, array_keys($usedKeys))) {
                $this->formulaHashes[$usedKeys[$key]] = array_map(fn ($value) => $this->extractHashes($value), $value);
            }

            $tmp[$key] = $valueFormatter($value);
        }

        return $tmp;
    }

    private function makeFormulaDescription($arguments, $result, $date, $metric, $type)
    {
        $value = makeFormulaDescription($arguments, $result, $date, $metric, $type);
        $value['body']['value_final'] = $this->formatPercentageValue($result);

        return $value;
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
}
