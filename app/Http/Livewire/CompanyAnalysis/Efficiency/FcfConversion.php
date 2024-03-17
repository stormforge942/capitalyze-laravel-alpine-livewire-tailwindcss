<?php

namespace App\Http\Livewire\CompanyAnalysis\Efficiency;

use Livewire\Component;
use App\Http\Livewire\CompanyAnalysis\HasFilters;

class FcfConversion extends Component
{
    use HasFilters;

    public $company;
    public $statements;
    public $rawData = [];
    public $chartConfig = [
        'showLabel' => true,
        'type' => 'percentage',
    ];

    public function mount()
    {
        $this->extractDates();

        $this->formatData();
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
        return view('livewire.company-analysis.efficiency.fcf-conversion', [
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

        $items = [
            'free_cashflow' => 'Free Cashflow',
            'cash_interest' => 'Cash Interest',
            'cash_taxes' => 'Cash Taxes',
            'capital_expenditures' => 'Capital Expenditures',
        ];

        $dataset[] = [
            'label' => 'Free Cashflow $',
            'data' => array_map(fn ($date) => [
                'x' => $this->formatDateForChart($date),
                'y' => $data['free_cashflow']['timeline'][$date] ?? 0,
            ], $this->selectedDates),
            "fill" => false,
            "borderColor" => '#121A0F',
            "backgroundColor" => '#121A0F',
            "type" => 'line',
            "yAxisID" => "y1",
            'pointRadius' => 0,
            'dataType' => 'value',
        ];

        $idx = 0;
        foreach ($items as $key => $label) {
            $values = $key === 'free_cashflow$' ? $data['free_cashflow'] : $data[$key];

            $dataset[] = [
                'label' => $label,
                'data' => array_map(fn ($date) => [
                    'x' => $this->formatDateForChart($date),
                    'y' => round(abs($values['ebitda_percentage'][$date] ?? 0), $this->decimalPlaces),
                ], $this->selectedDates),
                "borderRadius" => 2,
                "fill" => true,
                "backgroundColor" => $this->chartColors[$idx] ?? random_color(),
            ];

            $idx++;
        }

        return [
            'datasets' => $dataset,
            'avgFcf' => array_sum(array_map(fn ($date) => $data['free_cashflow']['ebitda_percentage'][$date] ?? 0, $this->selectedDates)) / count($this->selectedDates),
        ];
    }

    private function formatData()
    {
        $income = $this->statements[$this->period]['income_statement'];
        $cashflow = $this->statements[$this->period]['cash_flow'];

        $data = [
            'revenues' => [
                'timeline' => [],
                'yoy_change' => [],
            ],
            'ebitda' => [
                'timeline' => [],
                'yoy_change' => [],
                'margin' => [],
            ],
            'cash_interest' => [
                'timeline' => [],
                'yoy_change' => [],
                'ebitda_percentage' => [],
            ],
            'cash_taxes' => [
                'timeline' => [],
                'yoy_change' => [],
                'ebitda_percentage' => [],
            ],
            'capital_expenditures' => [
                'timeline' => [],
                'yoy_change' => [],
                'ebitda_percentage' => [],
                'revenue_percentage' => [],
            ],
            'free_cashflow' => [
                'timeline' => [],
                'yoy_change' => [],
                'ebitda_percentage' => [],
                'revenue_percentage' => [],
            ],
            'networth_change' => [
                'timeline' => [],
                'yoy_change' => [],
                'ebitda_percentage' => [],
                'revenue_percentage' => [],
            ],
            'levered_free_cashflow' => [
                'timeline' => [],
                'yoy_change' => [],
                'ebitda_percentage' => [],
                'margin' => [],
            ],
        ];

        $lastRev = 0;
        $lastEbitda = 0;
        $lastCashInterest = 0;
        $lastCashTaxes = 0;
        $lastCapitalExpenditure = 0;
        $lastFreeCashflow = 0;
        $lastNetworthChange = 0;
        $lastLeveredFreeCashflow = 0;
        foreach ($this->dates as $date) {
            $revenue = $income['Total Revenues'][$date] ?? 0;
            $data['revenues']['timeline'][$date] = $revenue;
            $data['revenues']['yoy_change'][$date] = $lastRev
                ? (($revenue / $lastRev) - 1) * 100
                : 0;
            $lastRev = $revenue;

            $ebitda = $income['EBITDA'][$date] ?? 0;
            $data['ebitda']['timeline'][$date] = $ebitda;
            $data['ebitda']['yoy_change'][$date] = $lastEbitda
                ? (($ebitda / $lastEbitda) - 1) * 100
                : 0;
            $data['ebitda']['margin'][$date] = $revenue
                ? ($ebitda / $revenue * 100)
                : 0;
            $lastEbitda = $ebitda;

            $cashInterest = abs($cashflow['Cash Interest Paid'][$date] ?? 0);
            $data['cash_interest']['timeline'][$date] = -1 * $cashInterest;
            $data['cash_interest']['yoy_change'][$date] = $lastCashInterest
                ? (($cashInterest / $lastCashInterest) - 1) * 100
                : 0;
            $data['cash_interest']['ebitda_percentage'][$date] = $ebitda
                ? -1 * ($cashInterest / $ebitda * 100)
                : 0;
            $lastCashInterest = $cashInterest;

            $cashTaxes = abs($cashflow['Cash Taxes Paid'][$date] ?? 0);
            $data['cash_taxes']['timeline'][$date] = -1 * $cashTaxes;
            $data['cash_taxes']['yoy_change'][$date] = $lastCashTaxes
                ? (($cashTaxes / $lastCashTaxes) - 1) * 100
                : 0;
            $data['cash_taxes']['ebitda_percentage'][$date] = $ebitda
                ? -1 * ($cashTaxes / $ebitda * 100)
                : 0;
            $lastCashTaxes = $cashTaxes;

            $capitalExpenditure = abs($cashflow['Capital Expenditure'][$date] ?? 0);
            $data['capital_expenditures']['timeline'][$date] = -1 * $capitalExpenditure;
            $data['capital_expenditures']['yoy_change'][$date] = $lastCapitalExpenditure
                ? (($capitalExpenditure / $lastCapitalExpenditure) - 1) * 100
                : 0;
            $data['capital_expenditures']['ebitda_percentage'][$date] = $ebitda
                ? -1 * ($capitalExpenditure / $ebitda * 100)
                : 0;
            $data['capital_expenditures']['revenue_percentage'][$date] = $revenue
                ? -1 * ($capitalExpenditure / $revenue * 100)
                : 0;
            $lastCapitalExpenditure = $capitalExpenditure;

            $freeCashflow = $ebitda - ($cashInterest + $cashTaxes + $capitalExpenditure);
            $data['free_cashflow']['timeline'][$date] = $freeCashflow;
            $data['free_cashflow']['yoy_change'][$date] = $lastFreeCashflow
                ? (($freeCashflow / $lastFreeCashflow) - 1) * 100
                : 0;
            $data['free_cashflow']['ebitda_percentage'][$date] = $ebitda
                ? ($freeCashflow / $ebitda * 100)
                : 0;
            $data['free_cashflow']['revenue_percentage'][$date] = $revenue
                ? ($freeCashflow / $revenue * 100)
                : 0;
            $lastFreeCashflow = $freeCashflow;

            $networthChange = $cashflow['Total Changes in Net Working Capital'][$date] ?? 0;
            $data['networth_change']['timeline'][$date] = $networthChange;
            $data['networth_change']['yoy_change'][$date] = $lastNetworthChange
                ? (($networthChange / $lastNetworthChange) - 1) * 100
                : 0;
            $data['networth_change']['ebitda_percentage'][$date] = $ebitda
                ? abs($networthChange / $ebitda * 100)
                : 0;
            $data['networth_change']['revenue_percentage'][$date] = $revenue
                ? abs($networthChange / $revenue * 100)
                : 0;
            $lastNetworthChange = $networthChange;

            $leveredFreeCashflow = $freeCashflow - $networthChange;
            $data['levered_free_cashflow']['timeline'][$date] = $leveredFreeCashflow;
            $data['levered_free_cashflow']['yoy_change'][$date] = $lastLeveredFreeCashflow
                ? (($leveredFreeCashflow / $lastLeveredFreeCashflow) - 1) * 100
                : 0;
            $data['levered_free_cashflow']['ebitda_percentage'][$date] = $ebitda
                ? ($leveredFreeCashflow / $ebitda * 100)
                : 0;
            $data['levered_free_cashflow']['margin'][$date] = $revenue
                ? ($leveredFreeCashflow / $revenue * 100)
                : 0;
            $lastLeveredFreeCashflow = $leveredFreeCashflow;
        }

        $this->rawData = $data;
    }

    private function extractDates()
    {
        $dates = [];

        foreach ($this->statements[$this->period]['income_statement'] as $values) {
            foreach ($values as $date => $val) {
                if (!in_array($date, $dates)) {
                    $dates[] = $date;
                }
            }
        }

        foreach ($this->statements[$this->period]['cash_flow'] as $values) {
            foreach ($values as $date => $val) {
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

        foreach ($data as $idx => $item) {
            foreach ($item as $key => $values) {
                $formatter = $key === 'timeline' ? $this->formatValue(...) : $this->formatPercentageValue(...);
                foreach ($values as $date => $value) {
                    $data[$idx][$key][$date] = [
                        'value' => $value,
                        'formatted' => $formatter($value),
                    ];
                }
            }
        }

        return $data;
    }
}
