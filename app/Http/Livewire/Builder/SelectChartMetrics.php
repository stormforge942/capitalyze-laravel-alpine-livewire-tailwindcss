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
                        'income||Total Revenue' => 'Total Revenue',
                        'income||Total Operating Income' => 'Total Operating Income',
                        'income||Total Operating Expenses' => 'Total Operating Expenses',
                        'balance||Cash & Equivalents' => 'Cash & Equivalents',
                        'balance||Total Receivable' => 'Total Receivable',
                        'balance||Total Current Assets' => 'Total Current Assets',
                    ]
                ],
                [
                    'title' => 'Balance Sheet',
                    'has_children' => false,
                    'items' => [
                        'balance||Cash & Equivalents' => 'Cash & Equivalents',
                        'balance||Short Term Investments' => 'Short Term Investments',
                        'balance||Total Cash And Short Term Investments' => 'Total Cash And Short Term Investments',
                        'balance||Accounts Receivable' => 'Accounts Receivable',
                        'balance||Other Receivable' => 'Other Receivable',
                        'balance||Total Receivable' => 'Total Receivable',
                        'balance||Inventory' => 'Inventory',
                        'balance||Deferred Tax Assets Current' => 'Deferred Tax Assets Current',
                        'balance||Other Current Assets' => 'Other Current Assets',
                        'balance||Total Current Assets' => 'Total Current Assets',
                    ]
                ],
                [
                    'title' => 'Income Statement',
                    'has_children' => true,
                    'items' => [
                        'Revenue' => [
                            'income||Total Revenue' => 'Total Revenue',
                            'income||Cost of Goods Sold' => 'Cost of Goods Sold',
                            'income||Total Gross Profit' => 'Total Gross Profit',
                        ],
                        'Income' => [
                            'income||Total Operating Income' => 'Total Operating Income',
                            'income||Interest & Investment Income' => 'Interest & Investment Income',
                            'income||Other Non Operating Income (Expenses)' => 'Other Non Operating Income (Expenses)',
                            'income||Earnings From Continuing Operations' => 'Earnings From Continuing Operations',
                            'income||Net Income to Company' => 'Net Income to Company',
                            'income||Net Income to Common' => 'Net Income to Common',
                            'income||Earnings Before Taxes (EBT)' => 'Earnings Before Taxes (EBT)',
                        ],
                        'Expenses' => [
                            'income||SG&A Expenses' => 'SG&A Expenses',
                            'income||R&D Expenses' => 'R&D Expenses',
                            'income||Total Operating Expenses' => 'Total Operating Expenses',
                            'income||Interest Expense' => 'Interest Expense',
                            'income||Income Tax Expense' => 'Income Tax Expense',
                        ],
                    ]
                ],
            ]
        ]);
    }
}
