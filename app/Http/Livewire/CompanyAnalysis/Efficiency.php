<?php

namespace App\Http\Livewire\CompanyAnalysis;

use Livewire\Component;
use App\Http\Livewire\AsTab;
use App\Models\InfoTikrPresentation;

class Efficiency extends Component
{
    use AsTab;

    public function mount($data)
    {
        $this->data = $data;
    }

    public function render()
    {
        $ticker = $this->data['company']['ticker'];

        $statements = InfoTikrPresentation::query()
            ->where('ticker', $ticker)
            ->whereIn("period", ['annual', 'quarter'])
            ->select(['period', 'income_statement', 'cash_flow'])
            ->get();

        $statements = [
            'annual' => $statements->firstWhere('period', 'annual'),
            'quarterly' => $statements->firstWhere('period', 'quarter'),
        ];

        foreach ($statements as $period => $item) {
            if ($statements[$period]) {
                $statements[$period]['income_statement'] = $this->formatIncomeData(json_decode($item['income_statement'], true));
                $statements[$period]['cash_flow'] = $this->formatCashFlowData(json_decode($item['cash_flow'], true));
            }
        }

        return view('livewire.company-analysis.efficiency', [
            'company' => $this->data['company'],
            'statements' => $statements,
        ]);
    }

    private function formatIncomeData($data)
    {
        $result = [];

        foreach ($data as $key => $value) {
            $key = explode("|", $key)[0];

            if (in_array($key, [
                'Cost of Goods Sold',
                'R&D Expenses',
                'SG&A Expenses',
                'Total Revenues',
                'EBITDA',
                'Total Operating Expenses'
            ])) {
                $result[$key] = $this->formatValue($value);
            }
        }

        return $result;
    }

    private function formatCashFlowData($data)
    {
        $result = [];

        foreach ($data as $key => $value) {
            $key = explode("|", $key)[0];

            if (in_array($key, [
                'Cash Interest Paid',
                'Cash Taxes Paid',
                'Capital Expenditure',
                'Total Changes in Net Working Capital',
            ])) {
                $result[$key] = $this->formatValue($value);
            }
        }

        return $result;
    }

    private function formatValue($value)
    {
        return array_map(fn ($val) => $val[0] ?? "", $value);
    }
}
