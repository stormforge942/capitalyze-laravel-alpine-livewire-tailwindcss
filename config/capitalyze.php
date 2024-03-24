<?php

return [
    'transaction_code_map' => [
        'P' => [
            'label' => 'Purchase',
            'description' => 'Open market or private purchase of non-derivative or derivative security'
        ],
        'S' => [
            'label' => 'Sale',
            'description' => 'Open market or private sale of non-derivative or derivative security'
        ],
        'V' => [
            'label' => 'Voluntary',
            'description' => 'Transaction voluntarily reported earlier than required'
        ],
        'A' => [
            'label' => 'Grant',
            'description' => 'Grant, award or other acquisition pursuant to Rule 16b-3(d)'
        ],
        'D' => [
            'label' => 'Disposition',
            'description' => 'Disposition to the issuer of issuer equity securities pursuant to Rule 16b-3(e)'
        ],
        'F' => [
            'label' => 'Payment',
            'description' => 'Payment of exercise price or tax liability by delivering or withholding securities incident to the receipt, exercise or vesting of a security issued in accordance with Rule 16b-3'
        ],
        'I' => [
            'label' => 'Discretionary',
            'description' => 'Discretionary transaction in accordance with Rule 16b-3(f) resulting in acquisition or disposition of issuer securities'
        ],
        'M' => [
            'label' => 'Exercise',
            'description' => 'Exercise or conversion of derivative security exempted pursuant to Rule 16b-3'
        ],
        'C' => [
            'label' => 'Conversion',
            'description' => 'Conversion of derivative security'
        ],
        'E' => [
            'label' => 'Expiration',
            'description' => 'Expiration of short derivative position'
        ],
        'H' => [
            'label' => 'Expiration/Cancellation',
            'description' => 'Expiration (or cancellation) of long derivative position with value received'
        ],
        'O' => [
            'label' => 'Out-of-the-money Exercise',
            'description' => 'Exercise of out-of-the-money derivative security'
        ],
        'X' => [
            'label' => 'In/at-the-money Exercise',
            'description' => 'Exercise of in-the-money or at-the-money derivative security'
        ],
        'G' => [
            'label' => 'Gift',
            'description' => 'Bona fide gift'
        ],
        'L' => [
            'label' => 'Small Acquisition',
            'description' => 'Small acquisition under Rule 16a-6'
        ],
        'W' => [
            'label' => 'Will/Descent',
            'description' => 'Acquisition or disposition by will or the laws of descent and distribution'
        ],
        'Z' => [
            'label' => 'Voting Trust',
            'description' => 'Deposit into or withdrawal from voting trust'
        ],
        'J' => [
            'label' => 'Other',
            'description' => 'Other acquisition or disposition (describe transaction)'
        ],
        'K' => [
            'label' => 'Equity Swap',
            'description' => 'Transaction in equity swap or instrument with similar characteristics'
        ],
        'U' => [
            'label' => 'Tender Disposition',
            'description' => 'Disposition pursuant to a tender of shares in a change of control transaction'
        ],
    ],
    'chartColors' => [
        "#464E49",
        "#9A46CD",
        "#52D3A2",
        "#3561E7",
        "#E38E48",
        "#39a80f",
        "#cb6c2d",
        "#8a2aa7",
        "#c47f2b",
        "#1634a3",
        "#F8BC20",
        "#9FB0EE",
        "#070cc6",
        "#d16882",
        "#C22929",
    ],
    'chart-builder-metrics' => [
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
    ]
];
