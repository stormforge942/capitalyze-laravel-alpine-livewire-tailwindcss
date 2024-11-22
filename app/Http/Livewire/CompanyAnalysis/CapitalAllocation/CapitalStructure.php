<?php

namespace App\Http\Livewire\CompanyAnalysis\CapitalAllocation;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\InfoTikrPresentation;
use App\Http\Livewire\CompanyAnalysis\HasFilters;
use Illuminate\Support\Facades\DB;

class CapitalStructure extends Component
{
    use HasFilters;

    public $company;
    public $rawData;
    public $publicView;
    public $formulaHashes = [];
    public $chartConfig = [
        'showLabel' => false,
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
        return view('livewire.company-analysis.capital-allocation.capital-structure', [
            'data' => $this->makeData(),
            'chart' => [
                'book' => [
                    'data' => $this->makeChartData('book'),
                    'key' => $this->makeChartKey() . ' - Book',
                ],
                'market' => [
                    'data' => $this->makeChartData('market'),
                    'key' => $this->makeChartKey() . ' - Market',
                ],
            ],
            'formulaHashes' => $this->formulaHashes,
        ]);
    }

    private function makeChartData(string $for): array
    {
        $data = $this->rawData[$for];

        $datasets = [];

        $datasets[] = [
            'label' => 'Net Debt / Capital',
            'data' => array_map(fn ($date) => [
                'x' => $this->formatDateForChart($date),
                'y' => round($data['net_debt_by_capital'][$date], 2),
            ], $this->selectedDates),
            "fill" => false,
            "borderColor" => '#121A0F',
            "backgroundColor" => '#121A0F',
            'yAxisID' => 'y1',
            'pointRadius' => 0,
            'dataType' => 'percentage',
        ];

        $datasets[] = [
            'label' => $for === 'book' ? 'Book Value of Common Equity' : 'Market Value Equity',
            'data' => array_map(fn ($date) => [
                'x' => $this->formatDateForChart($date),
                'y' => $data['equity']['timeline'][$date],
            ], $this->selectedDates),
            "fill" => true,
            "borderColor" => 'rgba(70, 78, 73, 0.40)',
            "backgroundColor" => 'rgba(70, 78, 73, 0.40)',
            'pointRadius' => 0,
        ];

        $datasets[] = [
            'label' => 'Total Debt',
            'data' => array_map(fn ($date) => [
                'x' => $this->formatDateForChart($date),
                'y' => $data['net_debt']['timeline'][$date],
            ], $this->selectedDates),
            "fill" => true,
            "borderColor" => 'rgba(53, 97, 231, 0.40)',
            "backgroundColor" => 'rgba(53, 97, 231, 0.40)',
            'pointRadius' => 0,
        ];

        $datasets[] = [
            'label' => 'Minority Interest',
            'data' => array_map(fn ($date) => [
                'x' => $this->formatDateForChart($date),
                'y' => $data['minority_interest']['timeline'][$date],
            ], $this->selectedDates),
            "fill" => true,
            "borderColor" => 'rgba(82, 211, 162, 0.40)',
            "backgroundColor" => 'rgba(82, 211, 162, 0.40)',
            'pointRadius' => 0,
        ];

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

                if ($key === 'net_debt_by_capital') {
                    $value[$key] = array_map(
                        fn ($val) => ['formatted' => $this->formatPercentageValue($val), 'value' => $val],
                        $row
                    );
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
        $eodPrices = $this->getEodAdjPrices();

        $data = [
            'book' => [
                'equity' => [
                    'timeline' => [],
                    'yoy_change' => [],
                    'total_percent' => [],
                ],
                'net_debt' => [
                    'timeline' => [],
                    'yoy_change' => [],
                    'total_percent' => [],
                ],
                'preferred_equity' => [
                    'timeline' => [],
                    'total_percent' => [],
                ],
                'minority_interest' => [
                    'timeline' => [],
                    'total_percent' => [],
                ],
                'total_value' => [
                    'timeline' => [],
                    'yoy_change' => [],
                ],
                'net_debt_by_capital' => [],
                'formulas' => []
            ],
            'market' => [
                'equity' => [
                    'timeline' => [],
                    'yoy_change' => [],
                    'total_percent' => [],
                ],
                'net_debt' => [
                    'timeline' => [],
                    'yoy_change' => [],
                    'total_percent' => [],
                ],
                'preferred_equity' => [
                    'timeline' => [],
                    'total_percent' => [],
                ],
                'minority_interest' => [
                    'timeline' => [],
                    'total_percent' => [],
                ],
                'total_value' => [
                    'timeline' => [],
                    'yoy_change' => [],
                ],
                'net_debt_by_capital' => [],
                'formulas' => []
            ],
        ];

        // for book
        $lastEquity = 0;
        $lastDebt = 0;
        $lastTotal = 0;
        foreach ($this->dates as $idx => $date) {
            $equity = $statement['Total Common Equity'][$date] ?? 0;
            $debt = $statement['Net Debt'][$date] ?? 0;
            $prefEquity = $statement['Total Preferred Equity'][$date] ?? 0;
            $minorityInterest = $statement['Minority Interest'][$date] ?? 0;

            $total = $equity + $debt + $prefEquity + $minorityInterest;

            $data['book']['total_value']['timeline'][$date] = (string) $total;
            $data['book']['total_value']['yoy_change'][$date] = (string) ($lastTotal && $idx ? (($total / $lastTotal) - 1) * 100 : 0);
            $data['book']['formulas']['total_value']['yoy_change'][$date] = $this->makeFormulaDescription([$total, $lastTotal], $data['book']['total_value']['yoy_change'][$date], $date, 'Total Enterprise Value', 'yoy_change');
            $data['book']['formulas']['total_value']['value'][$date] = $this->makeFormulaDescription([$equity, $debt, $prefEquity, $minorityInterest], $total, $date, 'Total Capital (Book Value)', 'total_enterprise_value');
            $lastTotal = $total;

            $data['book']['equity']['timeline'][$date] = (string) $equity;
            $data['book']['equity']['yoy_change'][$date] = (string) ($lastEquity && $idx ? (($equity / $lastEquity) - 1) * 100 : 0);
            $data['book']['formulas']['equity']['yoy_change'][$date] = $this->makeFormulaDescription([$equity, $lastEquity], $data['book']['equity']['yoy_change'][$date], $date, 'Market Value of Equity', 'yoy_change');
            $data['book']['equity']['total_percent'][$date] = (string) ($total ? $equity / $total * 100 : 0);
            $data['book']['formulas']['equity']['total_percent'][$date] = $this->makeFormulaDescription([$equity, $total], $data['book']['equity']['total_percent'][$date], $date, 'Market Value of Equity', 'of_total_capital');
            $lastEquity = $equity;

            $data['book']['net_debt']['timeline'][$date] = (string) $debt;
            $data['book']['net_debt']['yoy_change'][$date] = (string) ($lastDebt && $idx ? (($debt / $lastDebt) - 1) * 100 : 0);
            $data['book']['formulas']['net_debt']['yoy_change'][$date] = $this->makeFormulaDescription([$debt, $lastDebt], $data['book']['net_debt']['yoy_change'][$date], $date, 'Total Net Debt', 'yoy_change');
            $data['book']['net_debt']['total_percent'][$date] = (string) ($total ? $debt / $total * 100 : 0);
            $data['book']['formulas']['net_debt']['total_percent'][$date] = $this->makeFormulaDescription([$debt, $total], $data['book']['net_debt']['total_percent'][$date], $date, 'Total Net Debt', 'of_total_capital');
            $lastDebt = $debt;

            $data['book']['preferred_equity']['timeline'][$date] = (string) $prefEquity;
            $data['book']['preferred_equity']['total_percent'][$date] = (string) ($total ? $prefEquity / $total * 100 : 0);
            $data['book']['formulas']['preferred_equity']['total_percent'][$date] = $this->makeFormulaDescription([$prefEquity, $total], $data['book']['preferred_equity']['total_percent'][$date], $date, 'Preferred Equity', 'of_total_capital');

            $data['book']['minority_interest']['timeline'][$date] = (string) $minorityInterest;
            $data['book']['minority_interest']['total_percent'][$date] = (string) ($total ? $minorityInterest / $total * 100 : 0);
            $data['book']['formulas']['minority_interest']['total_percent'][$date] = $this->makeFormulaDescription([$minorityInterest, $total], $data['book']['minority_interest']['total_percent'][$date], $date, 'Minority Interest', 'of_total_capital');

            $data['book']['net_debt_by_capital'][$date] = (string) ($debt / $total * 100);
            $data['book']['formulas']['net_debt_by_capital'][$date] = $this->makeFormulaDescription([$debt, $total], $data['book']['net_debt_by_capital'][$date], $date, 'Net Debt / Capital', 'net_debt_by_capital');
        }

        // for market
        $lastEquity = 0;
        $lastDebt = 0;
        $lastTotal = 0;
        foreach ($this->dates as $idx => $date) {
            $equity = ($statement['Total Shares Out. on Filing Date'][$date] ?? 0) * $this->findClosestEodPrice($eodPrices, $date);
            $debt = $statement['Net Debt'][$date] ?? 0;
            $prefEquity = $statement['Total Preferred Equity'][$date] ?? 0;
            $minorityInterest = $statement['Minority Interest'][$date] ?? 0;

            $total = $equity + $debt + $prefEquity + $minorityInterest;

            $data['market']['total_value']['timeline'][$date] = (string) $total;
            $data['market']['total_value']['yoy_change'][$date] = (string) ($lastTotal && $idx ? (($total / $lastTotal) - 1) * 100 : 0);
            $data['market']['formulas']['total_value']['yoy_change'][$date] = $this->makeFormulaDescription([$total, $lastTotal], $data['market']['total_value']['yoy_change'][$date], $date, 'Total Enterprise Value', 'yoy_change');
            $data['market']['formulas']['total_value']['value'][$date] = $this->makeFormulaDescription([$equity, $debt, $prefEquity, $minorityInterest], $total, $date, 'Total Enterprise Value', 'total_enterprise_value');
            $lastTotal = $total;

            $data['market']['equity']['timeline'][$date] = (string) $equity;
            $data['market']['formulas']['equity']['market_value_of_equity'][$date] = $this->makeFormulaDescription([$statement['Total Shares Out. on Filing Date'][$date], $this->findClosestEodPrice($eodPrices, $date)], $equity, $date, 'Market Value of Equity', 'market_value_of_equity');
            $data['market']['equity']['yoy_change'][$date] = (string) ($lastEquity && $idx ? (($equity / $lastEquity) - 1) * 100 : 0);
            $data['market']['formulas']['equity']['yoy_change'][$date] = $this->makeFormulaDescription([$equity, $lastEquity], $data['market']['equity']['yoy_change'][$date], $date, 'Market Value of Common Equity', 'yoy_change');
            $data['market']['equity']['total_percent'][$date] = (string) ($total ? $equity / $total * 100 : 0);
            $data['market']['formulas']['equity']['total_percent'][$date] = $this->makeFormulaDescription([$equity, $total], $data['market']['equity']['total_percent'][$date], $date, 'Market Value of Common Equity', 'of_total_capital');
            $lastEquity = $equity;

            $data['market']['net_debt']['timeline'][$date] = (string) $debt;
            $data['market']['net_debt']['yoy_change'][$date] = (string) ($lastDebt && $idx ? (($debt / $lastDebt) - 1)  * 100 : 0);
            $data['market']['formulas']['net_debt']['yoy_change'][$date] = $this->makeFormulaDescription([$debt, $lastDebt], $data['market']['net_debt']['yoy_change'][$date], $date, 'Total Net Debt', 'yoy_change');
            $data['market']['net_debt']['total_percent'][$date] = (string) ($total ? $debt / $total * 100 : 0);
            $data['market']['formulas']['net_debt']['total_percent'][$date] = $this->makeFormulaDescription([$debt, $total], $data['market']['net_debt']['total_percent'][$date], $date, 'Total Net Debt', 'of_total_capital');
            $lastDebt = $debt;

            $data['market']['preferred_equity']['timeline'][$date] = (string) $prefEquity;
            $data['market']['preferred_equity']['total_percent'][$date] = (string) ($total ? $prefEquity / $total * 100 : 0);
            $data['market']['formulas']['preferred_equity']['total_percent'][$date] = $this->makeFormulaDescription([$prefEquity, $total], $data['market']['preferred_equity']['total_percent'][$date], $date, 'Preferred Equity', 'of_total_capital');

            $data['market']['minority_interest']['timeline'][$date] = (string) $minorityInterest;
            $data['market']['minority_interest']['total_percent'][$date] = (string) ($total ? $minorityInterest / $total * 100 : 0);
            $data['market']['formulas']['minority_interest']['total_percent'][$date] = $this->makeFormulaDescription([$minorityInterest, $total], $data['market']['minority_interest']['total_percent'][$date], $date, 'Minority Interest', 'of_total_capital');

            $data['market']['net_debt_by_capital'][$date] = (string) ($debt / $total * 100);
            $data['market']['formulas']['net_debt_by_capital'][$date] = $this->makeFormulaDescription([$debt, $total], $data['market']['net_debt_by_capital'][$date], $date, 'Net Debt / Capital', 'net_debt_by_capital');
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
                ->value('balance_sheet'),
            true
        ), false);

        $usedKeys = [
            'Total Common Equity' => 'total_equity',
            'Net Debt' => 'net_debt',
            'Total Preferred Equity' => 'total_preferred_equity',
            'Minority Interest' => 'minimum_interest',
            'Total Shares Out. on Filing Date' => 'total_shares_out',
        ];

        $valueFormatter = fn ($value) => array_map(fn ($val) => intval(explode("|", $val[0] ?? "")[0]), $value);

        $tmp = [];

        if ($data) {
            foreach ($data as $key => $value) {
                $key = explode("|", $key)[0];
    
                if (!in_array($key, array_keys($usedKeys))) continue;
    
                if (in_array($key, ['Net Debt', 'Total Common Equity'])) {
                    $this->formulaHashes[$usedKeys[$key]] = array_map(fn ($value) => $this->extractHashes($value), $value);
                }
    
                $tmp[$key] = $valueFormatter($value);
            }
        }

        return $tmp;
    }

    private function getEodAdjPrices()
    {
        $tmp = [];

        if (count($this->dates)) {
            $range = [
                intval(explode('-', $this->dates[0])[0]),
                intval(explode('-', $this->dates[count($this->dates) - 1])[0])
            ];
        

            $prices = DB::connection('pgsql-xbrl')
                ->table('eod_prices')
                ->whereBetween(DB::raw("TO_DATE(date, 'YYYY-MM-DD')"), [
                    "{$range[0]}-01-01",
                    "{$range[1]}-12-31",
                ])
                ->where('symbol', strtolower($this->company['ticker']))
                ->get(['date', 'adj_close']);

            // conver the array to this way [2021 => [02 => [29 => 123]]]
            foreach ($prices as $price) {
                [$year, $month, $day] = array_map(fn ($a) => intval($a), explode('-', $price->date));

                data_set($tmp, "{$year}.{$month}.{$day}", floatval($price->adj_close));
            }
        }

        return $tmp;
    }

    private function findClosestEodPrice($eodPrices, $date): int|float
    {
        [$year, $month, $day] = explode('-', $date);

        $year = intval($year);
        $originalYear = $year;
        $month = intval($month);
        $day = intval($day);

        $values = data_get($eodPrices, "{$year}.{$month}", []);

        while (true) {
            for ($i = intval($day); $i > 0; $i--) {
                $price = data_get($values, "{$i}");

                // found it
                if ($price) {
                    return $price;
                }
            }

            // Decrease the year if the month is 1 or decrease the month
            if ($month === 1) {
                $year--;

                // if the year is 2 years before the original year, then return 0
                if ($year === $originalYear - 2) return 0;

                $month = 12;
            } else {
                $month--;
            }

            if ($day === 1) {
                $month--;
                $day = 31;
            } else {
                $day--;
            }
        }

        return 0;
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
