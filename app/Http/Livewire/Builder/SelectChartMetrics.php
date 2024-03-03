<?php

namespace App\Http\Livewire\Builder;

use Livewire\Component;

class SelectChartMetrics extends Component
{
    public function render()
    {
        return view('livewire.builder.select-chart-metrics', [
            'options' => [
                [
                    'title' => 'Popular Selections',
                    'has_children' => false,
                    'items' => [
                        'income||revenue||tr' => 'Total Revenue',
                        'income||income||toi' => 'Total Operating Income',
                        'income||expenses||toe' => 'Total Operating Expenses',
                    ]
                ],
                [
                    'title' => 'Balance Sheet',
                    'has_children' => false,
                    'items' => [
                        'balance||cae' => 'Cash & Equivalents',
                        'balance||stl' => 'Short Term Investments',
                        'balance||tcasti' => 'Total Cash And Short Term Investments',
                        'balance||ar' => 'Accounts Receivable',
                        'balance||or' => 'Other Receivable',
                        'balance||tr' => 'Total Receivable',
                        'balance||inv' => 'Inventory',
                        'balance||dfac' => 'Deferred Tax Assets Current',
                        'balance||oa' => 'Other Current Assets',
                        'balance||tca' => 'Total Current Assets',
                    ]
                ],
                [
                    'title' => 'Income Statement',
                    'has_children' => true,
                    'items' => [
                        'Revenue' => [
                            'income||revenue||tr' => 'Total Revenue',
                            'income||revenue||cogs' => 'Cost of Goods Sold',
                            'income||revenue||tgp' => 'Total Gross Profit',
                        ],
                        'Income' => [
                            'income||income||toi' => 'Total Operating Income',
                            'income||income||iii' => 'Interest & Investment Income',
                            'income||income||onoi' => 'Other Non Operating Income (Expenses)',
                            'income||income||efco' => 'Earnings From Continuing Operations',
                            'income||income||nitcy' => 'Net Income to Company',
                            'income||income||nitcn' => 'Net Income to Common',
                            'income||income||ebt' => 'Earnings Before Taxes (EBT)',
                        ],
                        'Expenses' => [
                            'income||expenses||sga' => 'SG&A Expenses',
                            'income||expenses||rd' => 'R&D Expenses',
                            'income||expenses||toe' => 'Total Operating Expenses',
                            'income||expenses||ie' => 'Interest Expense',
                            'income||expenses||ite' => 'Income Tax Expense',
                        ],
                    ]
                ],
            ]
        ]);
    }
}
