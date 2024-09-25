<?php

namespace App\Http\Livewire\CompanyAnalysis\Efficiency;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Http\Livewire\CompanyAnalysis\HasFilters;

class FcfConversion extends Component
{
    use HasFilters;

    public $company;
    public $statements;
    public $rawData = [];
    public $publicView;
    public $chartConfig = [
        'showLabel' => false,
        'type' => 'percentage',
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
            'formulas' => [],
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
            $revenue = isset($income['Total Revenues'][$date]) ? $this->extractValues($income['Total Revenues'][$date])['value'] : 0;
            $data['revenues']['timeline'][$date] = $revenue;
            $data['revenues']['hash'][$date] = isset($income['Total Revenues'][$date]) ? $this->extractValues($income['Total Revenues'][$date])['hash'] : null;
            $data['revenues']['secondHash'][$date] = isset($income['Total Revenues'][$date]) ? $this->extractValues($income['Total Revenues'][$date])['secondHash'] : null;
            $data['revenues']['yoy_change'][$date] = $lastRev
                ? (($revenue / $lastRev) - 1) * 100
                : 0;

            $data['revenues']['formulas']['yoy_change'][$date] = $this->makeFormulaDescription([$revenue, $lastRev], $data['revenues']['yoy_change'][$date], $date, 'Total revenues', 'yoy_change');

            $lastRev = $revenue;

            $ebitda = isset($income['EBITDA'][$date]) ? $this->extractValues($income['EBITDA'][$date])['value'] : 0;
            $data['ebitda']['timeline'][$date] = $ebitda;
            $data['ebitda']['hash'][$date] = isset($income['EBITDA'][$date]) ? $this->extractValues($income['EBITDA'][$date])['hash'] : null;
            $data['ebitda']['secondHash'][$date] = isset($income['EBITDA'][$date]) ? $this->extractValues($income['EBITDA'][$date])['secondHash'] : null;
            $data['ebitda']['yoy_change'][$date] = $lastEbitda
                ? (($ebitda / $lastEbitda) - 1) * 100
                : 0;
            $data['ebitda']['margin'][$date] = $revenue
                ? ($ebitda / $revenue * 100)
                : 0;

            $data['ebitda']['formulas']['yoy_change'][$date] = $this->makeFormulaDescription([$ebitda, $lastEbitda], $data['ebitda']['yoy_change'][$date], $date, 'EBITDA', 'yoy_change');
            $data['ebitda']['formulas']['margin'][$date] = $this->makeFormulaDescription([$ebitda, $revenue], $data['ebitda']['margin'][$date], $date, 'EBITDA', 'margin');

            $lastEbitda = $ebitda;

            $cashInterest = isset($cashflow['Cash Interest Paid'][$date]) ? abs($this->extractValues($cashflow['Cash Interest Paid'][$date])['value']) : 0;
            $data['cash_interest']['timeline'][$date] = -1 * $cashInterest;
            $data['cash_interest']['hash'][$date] = isset($cashflow['Cash Interest Paid'][$date]) ? $this->extractValues($cashflow['Cash Interest Paid'][$date])['hash'] : null;
            $data['cash_interest']['secondHash'][$date] = isset($cashflow['Cash Interest Paid'][$date]) ? $this->extractValues($cashflow['Cash Interest Paid'][$date])['secondHash'] : null;
            $data['cash_interest']['yoy_change'][$date] = $lastCashInterest
                ? (($cashInterest / $lastCashInterest) - 1) * 100
                : 0;
            $data['cash_interest']['ebitda_percentage'][$date] = $ebitda
                ? -1 * ($cashInterest / $ebitda * 100)
                : 0;

            $data['cash_interest']['formulas']['yoy_change'][$date] = $this->makeFormulaDescription([$cashInterest, $lastCashInterest], $data['cash_interest']['yoy_change'][$date], $date, 'Cash Interest Paid', 'yoy_change');
            $data['cash_interest']['formulas']['ebitda_percentage'][$date] = $this->makeFormulaDescription([$cashInterest, $ebitda], $data['cash_interest']['ebitda_percentage'][$date], $date, 'Cash Interest Paid', 'of_ebitda');

            $lastCashInterest = $cashInterest;

            $cashTaxes = isset($cashflow['Cash Taxes Paid'][$date]) ? abs($this->extractValues($cashflow['Cash Taxes Paid'][$date])['value']) : 0;
            $data['cash_taxes']['timeline'][$date] = -1 * $cashTaxes;
            $data['cash_taxes']['hash'][$date] = isset($cashflow['Cash Taxes Paid'][$date]) ? $this->extractValues($cashflow['Cash Taxes Paid'][$date])['hash'] : 0;
            $data['cash_taxes']['secondHash'][$date] = isset($cashflow['Cash Taxes Paid'][$date]) ? $this->extractValues($cashflow['Cash Taxes Paid'][$date])['secondHash'] : 0;
            $data['cash_taxes']['yoy_change'][$date] = $lastCashTaxes
                ? (($cashTaxes / $lastCashTaxes) - 1) * 100
                : 0;
            $data['cash_taxes']['ebitda_percentage'][$date] = $ebitda
                ? -1 * ($cashTaxes / $ebitda * 100)
                : 0;

            $data['cash_taxes']['formulas']['yoy_change'][$date] = $this->makeFormulaDescription([$cashTaxes, $lastCashTaxes], $data['cash_taxes']['yoy_change'][$date], $date, 'Cash Taxes Paid', 'yoy_change');
            $data['cash_taxes']['formulas']['ebitda_percentage'][$date] = $this->makeFormulaDescription([$cashInterest, $ebitda], $data['cash_taxes']['ebitda_percentage'][$date], $date, 'Cash Taxes Paid', 'of_ebitda');

            $lastCashTaxes = $cashTaxes;

            $capitalExpenditure = isset($cashflow['Capital Expenditure'][$date]) ? abs($this->extractValues($cashflow['Capital Expenditure'][$date])['value']) : 0;
            $data['capital_expenditures']['timeline'][$date] = -1 * $capitalExpenditure;
            $data['capital_expenditures']['hash'][$date] = isset($cashflow['Capital Expenditure'][$date]) ? $this->extractValues($cashflow['Capital Expenditure'][$date])['hash'] : null;
            $data['capital_expenditures']['secondHash'][$date] = isset($cashflow['Capital Expenditure'][$date]) ? $this->extractValues($cashflow['Capital Expenditure'][$date])['secondHash'] : null;
            $data['capital_expenditures']['yoy_change'][$date] = $lastCapitalExpenditure
                ? (($capitalExpenditure / $lastCapitalExpenditure) - 1) * 100
                : 0;
            $data['capital_expenditures']['ebitda_percentage'][$date] = $ebitda
                ? -1 * ($capitalExpenditure / $ebitda * 100)
                : 0;
            $data['capital_expenditures']['revenue_percentage'][$date] = $revenue
                ? -1 * ($capitalExpenditure / $revenue * 100)
                : 0;

            $data['capital_expenditures']['formulas']['yoy_change'][$date] = $this->makeFormulaDescription([$capitalExpenditure, $lastCapitalExpenditure], $data['capital_expenditures']['yoy_change'][$date], $date, 'Capital Expenditure', 'yoy_change');
            $data['capital_expenditures']['formulas']['of_total_revenue'][$date] = $this->makeFormulaDescription([$capitalExpenditure, $revenue], $data['capital_expenditures']['revenue_percentage'][$date], $date, 'Capital Expenditure', 'of_total_revenue');
            $data['capital_expenditures']['formulas']['ebitda_percentage'][$date] = $this->makeFormulaDescription([$capitalExpenditure, $ebitda], $data['capital_expenditures']['ebitda_percentage'][$date], $date, 'Capital Expenditure', 'of_ebitda');

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


            $data['free_cashflow']['formulas']['free_cashflow'][$date] = $this->makeFormulaDescription([$ebitda, $cashInterest, $cashTaxes, $capitalExpenditure], $freeCashflow, $date, 'Free Cashflow', 'free_cashflow');
            $data['free_cashflow']['formulas']['yoy_change'][$date] = $this->makeFormulaDescription([$freeCashflow, $lastFreeCashflow], $data['free_cashflow']['yoy_change'][$date], $date, 'Free Cashflow', 'yoy_change');
            $data['free_cashflow']['formulas']['of_total_revenue'][$date] = $this->makeFormulaDescription([$freeCashflow, $revenue], $data['free_cashflow']['revenue_percentage'][$date], $date, 'Free Cashflow', 'of_total_revenue');
            $data['free_cashflow']['formulas']['ebitda_percentage'][$date] = $this->makeFormulaDescription([$freeCashflow, $ebitda], $data['free_cashflow']['ebitda_percentage'][$date], $date, 'Free Cashflow', 'of_ebitda');

            $lastFreeCashflow = $freeCashflow;

            $networthChange = isset($cashflow['Total Changes in Net Working Capital'][$date]) ? $this->extractValues($cashflow['Total Changes in Net Working Capital'][$date])['value'] : 0;
            $data['networth_change']['timeline'][$date] = $networthChange;
            $data['networth_change']['hash'][$date] = isset($cashflow['Total Changes in Net Working Capital'][$date]) ? $this->extractValues($cashflow['Total Changes in Net Working Capital'][$date])['hash'] : null;
            $data['networth_change']['secondHash'][$date] = isset($cashflow['Total Changes in Net Working Capital'][$date]) ? $this->extractValues($cashflow['Total Changes in Net Working Capital'][$date])['secondHash'] : null;
            $data['networth_change']['yoy_change'][$date] = $lastNetworthChange
                ? (($networthChange / $lastNetworthChange) - 1) * 100
                : 0;
            $data['networth_change']['ebitda_percentage'][$date] = $ebitda
                ? abs($networthChange / $ebitda * 100)
                : 0;
            $data['networth_change']['revenue_percentage'][$date] = $revenue
                ? abs($networthChange / $revenue * 100)
                : 0;

            $data['networth_change']['formulas']['yoy_change'][$date] = $this->makeFormulaDescription([$networthChange, $lastNetworthChange], $data['networth_change']['yoy_change'][$date], $date, 'Total Changes in Net Working Capital', 'yoy_change');
            $data['networth_change']['formulas']['ebitda_percentage'][$date] = $this->makeFormulaDescription([$networthChange, $ebitda], $data['networth_change']['ebitda_percentage'][$date], $date, 'Total Changes in Net Working Capital', 'of_ebitda');
            $data['networth_change']['formulas']['revenue_percentage'][$date] = $this->makeFormulaDescription([$networthChange, $revenue], $data['networth_change']['revenue_percentage'][$date], $date, 'Total Changes in Net Working Capital', 'of_total_revenue');

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

            $data['levered_free_cashflow']['formulas']['levered_free_cashflow'][$date] = $this->makeFormulaDescription([$freeCashflow, $networthChange], $leveredFreeCashflow, $date, 'Levered Free Cash Flow', 'levered_free_cashflow');
            $data['levered_free_cashflow']['formulas']['yoy_change'][$date] = $this->makeFormulaDescription([$leveredFreeCashflow, $lastLeveredFreeCashflow], $data['levered_free_cashflow']['yoy_change'][$date], $date, 'Levered Free Cash Flow', 'yoy_change');
            $data['levered_free_cashflow']['formulas']['lcf_margin'][$date] = $this->makeFormulaDescription([$leveredFreeCashflow, $revenue], $data['levered_free_cashflow']['margin'][$date], $date, 'Levered Free Cash Flow', 'lcf_margin');
            $data['levered_free_cashflow']['formulas']['ebitda_percentage'][$date] = $this->makeFormulaDescription([$leveredFreeCashflow, $ebitda], $data['levered_free_cashflow']['ebitda_percentage'][$date], $date, 'Levered Free Cash Flow', 'of_ebitda');

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
                if (in_array($key, ['hash', 'secondHash', 'formulas'])) {
                    continue;
                }

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

    private function extractValues($value)
    {
        list($extractedValue, $hash, $secondHash) = array_pad(explode("|", $value ?? ""), 3, null);

        return [
            'value' => intval($extractedValue),
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
