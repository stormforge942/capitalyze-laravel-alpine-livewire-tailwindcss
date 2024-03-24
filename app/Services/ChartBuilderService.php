<?php

namespace App\Services;

class ChartBuilderService
{
    public static function options($flattened = false)
    {
        $options = [
            [
                'title' => 'Popular Selections',
                'has_children' => false,
                'items' => [
                    'income_statement||Total Revenues' => [
                        'title' => 'Total Revenues',
                    ],
                    'income_statement||Total Operating Income' => [
                        'title' => 'Total Operating Income',
                    ],
                    'income_statement||Total Operating Expenses' => [
                        'title' => 'Total Operating Expenses',
                    ],
                    'balance_sheet||Cash And Equivalents' => [
                        'title' => 'Cash & Equivalents',
                    ],
                    'balance_sheet||Total Receivables' => [
                        'title' => 'Total Receivables',
                    ],
                    'balance_sheet||Total Current Assets' => [
                        'title' => 'Total Current Assets',
                    ],
                ]
            ],
            [
                'title' => 'Balance Sheet',
                'has_children' => false,
                'items' => [
                    'balance_sheet||Cash And Equivalents' => [
                        'title' => 'Cash & Equivalents',
                    ],
                    'balance_sheet||Short Term Investments' => [
                        'title' => 'Short Term Investments',
                    ],
                    'balance_sheet||Total Cash And Short Term Investments' => [
                        'title' => 'Total Cash And Short Term Investments',
                    ],
                    'balance_sheet||Accounts Receivable' => [
                        'title' => 'Accounts Receivable',
                    ],
                    'balance_sheet||Other Receivable' => [
                        'title' => 'Other Receivable',
                    ],
                    'balance_sheet||Total Receivables' => [
                        'title' => 'Total Receivables',
                    ],
                    'balance_sheet||Inventory' => [
                        'title' => 'Inventory',
                    ],
                    'balance_sheet||Deferred Tax Assets Current' => [
                        'title' => 'Deferred Tax Assets Current',
                    ],
                    'balance_sheet||Other Current Assets' => [
                        'title' => 'Other Current Assets',
                    ],
                    'balance_sheet||Total Current Assets' => [
                        'title' => 'Total Current Assets',
                    ],
                ]
            ],
            [
                'title' => 'Income Statement',
                'has_children' => true,
                'items' => [
                    'Revenue' => [
                        'income_statement||Total Revenues' => [
                            'title' => 'Total Revenue',
                        ],
                        'income_statement||Cost of Goods Sold' => [
                            'title' => 'Cost of Goods Sold',
                        ],
                        'income_statement||Total Gross Profit' => [
                            'title' => 'Total Gross Profit',
                        ],
                    ],
                    'Income' => [
                        'income_statement||Total Operating Income' => [
                            'title' => 'Total Operating Income',
                        ],
                        'income_statement||Interest & Investment Income' => [
                            'title' => 'Interest & Investment Income',
                        ],
                        'income_statement||Other Non Operating Income (Expenses)' => [
                            'title' => 'Other Non Operating Income (Expenses)',
                        ],
                        'income_statement||Earnings From Continuing Operations' => [
                            'title' => 'Earnings From Continuing Operations',
                        ],
                        'income_statement||Net Income to Company' => [
                            'title' => 'Net Income to Company',
                        ],
                        'income_statement||Net Income to Common' => [
                            'title' => 'Net Income to Common',
                        ],
                        'income_statement||Earnings Before Taxes (EBT)' => [
                            'title' => 'Earnings Before Taxes (EBT)',
                        ],
                        'income_statement||Dividends per share' => [
                            'title' => 'Dividends per share',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'income_statement||Payout Ratio %' => [
                            'title' => 'Payout Ratio',
                            'type' => 'line',
                            'yAxis' => 'percent',
                        ],
                    ],
                    'Expenses' => [
                        'income_statement||SG&A Expenses' => [
                            'title' => 'SG&A Expenses',
                        ],
                        'income_statement||R&D Expenses' => [
                            'title' => 'R&D Expenses',
                        ],
                        'income_statement||Total Operating Expenses' => [
                            'title' => 'Total Operating Expenses',
                        ],
                        'income_statement||Interest Expense' => [
                            'title' => 'Interest Expense',
                        ],
                        'income_statement||Income Tax Expense' => [
                            'title' => 'Income Tax Expense',
                        ],
                    ],
                ]
            ],
        ];

        if (!$flattened) {
            return $options;
        }

        $flattenedOptions = [];

        foreach ($options as $option) {
            if ($option['has_children']) {
                foreach ($option['items'] as $items) {
                    foreach ($items as $key => $item) {
                        $flattenedOptions[$key] = $item;
                    }
                }
            } else {
                foreach ($option['items'] as $key => $item) {
                    $flattenedOptions[$key] = $item;
                }
            }
        }

        return $flattenedOptions;
    }
}
