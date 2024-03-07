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
                        'income_statement||Total Revenue' => 'Total Revenue',
                        'income_statement||Total Operating Income' => 'Total Operating Income',
                        'income_statement||Total Operating Expenses' => 'Total Operating Expenses',
                        'balance_sheet||Cash & Equivalents' => 'Cash & Equivalents',
                        'balance_sheet||Total Receivable' => 'Total Receivable',
                        'balance_sheet||Total Current Assets' => 'Total Current Assets',
                    ]
                ],
                [
                    'title' => 'Balance Sheet',
                    'has_children' => false,
                    'items' => [
                        'balance_sheet||Cash & Equivalents' => 'Cash & Equivalents',
                        'balance_sheet||Short Term Investments' => 'Short Term Investments',
                        'balance_sheet||Total Cash And Short Term Investments' => 'Total Cash And Short Term Investments',
                        'balance_sheet||Accounts Receivable' => 'Accounts Receivable',
                        'balance_sheet||Other Receivable' => 'Other Receivable',
                        'balance_sheet||Total Receivable' => 'Total Receivable',
                        'balance_sheet||Inventory' => 'Inventory',
                        'balance_sheet||Deferred Tax Assets Current' => 'Deferred Tax Assets Current',
                        'balance_sheet||Other Current Assets' => 'Other Current Assets',
                        'balance_sheet||Total Current Assets' => 'Total Current Assets',
                    ]
                ],
                [
                    'title' => 'Income Statement',
                    'has_children' => true,
                    'items' => [
                        'Revenue' => [
                            'income_statement||Total Revenue' => 'Total Revenue',
                            'income_statement||Cost of Goods Sold' => 'Cost of Goods Sold',
                            'income_statement||Total Gross Profit' => 'Total Gross Profit',
                        ],
                        'Income' => [
                            'income_statement||Total Operating Income' => 'Total Operating Income',
                            'income_statement||Interest & Investment Income' => 'Interest & Investment Income',
                            'income_statement||Other Non Operating Income (Expenses)' => 'Other Non Operating Income (Expenses)',
                            'income_statement||Earnings From Continuing Operations' => 'Earnings From Continuing Operations',
                            'income_statement||Net Income to Company' => 'Net Income to Company',
                            'income_statement||Net Income to Common' => 'Net Income to Common',
                            'income_statement||Earnings Before Taxes (EBT)' => 'Earnings Before Taxes (EBT)',
                        ],
                        'Expenses' => [
                            'income_statement||SG&A Expenses' => 'SG&A Expenses',
                            'income_statement||R&D Expenses' => 'R&D Expenses',
                            'income_statement||Total Operating Expenses' => 'Total Operating Expenses',
                            'income_statement||Interest Expense' => 'Interest Expense',
                            'income_statement||Income Tax Expense' => 'Income Tax Expense',
                        ],
                    ]
                ],
            ]
        ]);
    }
}
