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
        "#52D3A2",
        "#3561E7",
        "#3F5765",
        "#4D2C29",
        "#6467BC",
        "#828C85",
        "#DA680B",
        "#6645A9",
        "#E53E8F",
        "#C22929",
        "#1D1351",

        '#393a14',
        '#030802',
        '#2f1431',
        '#0f0003',
        '#0d1a01',
        '#000000',
        '#603006',
        '#493c04',
        '#3d2b0e',
        '#051330',
        '#2c170c',
        '#192003',
        '#271809',
        '#0e392b',
        '#272a7c',
        '#16362c',
        '#712540',
        '#0e2633',
        '#1b0b40',
        '#021101',
        '#010403',
        '#1c0f03',
        '#010001',
        '#102b2d',
        '#6d2246',
        '#084d62',
        '#114f3c',
        '#300f21',
        '#0b038f',
        '#0f1402',
        '#050921',
        '#1b3109',
        '#010001',
        '#030217',
        '#3d2003',
        '#012b2a',
        '#55321d',
        '#050003',
        '#4c4622',
        '#453a19',
        '#281b48',
        '#290919',
        '#000405',
        '#282b01',
        '#3b2600',
        '#060f04',
        '#550053',
        '#1b3c56',
        '#061a1d',
        '#0e2a29',
    ],
    'standardized_metrics' => [
        [
            'title' => 'Income Statement',
            'has_children' => false,
            'items' => [
                'income_statement||Total Revenues' => [
                    'title' => 'Total Revenue',
                    'mapping' => [
                        'self' => 'is_0030',
                        'yoy_change' => 'is_0040',
                    ],
                ],
                'income_statement||Cost of Goods Sold' => [
                    'title' => 'Cost of Goods Sold',
                    'mapping' => [
                        'self' => 'is_0050',
                    ],
                ],
                'income_statement||Total Gross Profits' => [
                    'title' => 'Total Gross Profits',
                    'mapping' => [
                        'self' => 'is_0070',
                        'yoy_change' => 'is_0080',
                    ],
                ],
                'income_statement||SG&A Expenses' => [
                    'title' => 'SG&A Expenses',
                    'mapping' => [
                        'self' => 'is_0110',
                    ],
                ],
                'income_statement||R&D Expenses' => [
                    'title' => 'R&D Expenses',
                    'mapping' => [
                        'self' => 'is_0120',
                    ],
                ],
                'income_statement||Interest Expense' => [
                    'title' => 'Interest Expense',
                    'mapping' => [
                        'self' => 'is_0200',
                    ],
                ],
                'income_statement||EBT - Excluding Unusual Items' => [
                    'title' => 'EBT - Excluding Unusual Items',
                    'mapping' => [
                        'self' => 'is_0260',
                    ],
                ],
                'income_statement||Earnings Before Taxes (EBT)' => [
                    'title' => 'Earnings Before Taxes (EBT)',
                    'mapping' => [
                        'self' => 'is_0360',
                    ],
                ],
                'income_statement||Income Tax Expense' => [
                    'title' => 'Income Tax Expense',
                    'mapping' => [
                        'self' => 'is_0380',
                    ],
                ],
                'income_statement||Earnings From Continuing Operations' => [
                    'title' => 'Earnings From Continuing Operations',
                    'mapping' => [
                        'self' => 'is_0400',
                    ],
                ],
                'income_statement||Net Income to Company' => [
                    'title' => 'Net Income to Company',
                    'mapping' => [
                        'self' => 'is_0430',
                    ],
                ],
                'income_statement||Net Income to Common' => [
                    'title' => 'Net Income to Common',
                    'mapping' => [
                        'self' => 'is_0460',
                        'yoy_change' => 'is_0470',
                    ],
                ],
                'income_statement||Weighted Avg. Diluted Shares Outstanding' => [
                    'title' => 'Weighted Avg. Diluted Shares Outstanding',
                    'mapping' => [
                        'self' => 'is_0500',
                        'yoy_change' => 'is_0510',
                    ],
                ],
                'income_statement||Diluted Earnings Per Share' => [
                    'title' => 'Diluted Earnings Per Share',
                    'type' => 'line',
                    'yAxis' => 'ratio',
                    'mapping' => [
                        'self' => 'is_0520',
                        'yoy_change' => 'is_0530',
                    ],
                ],
                'income_statement||Weighted Average Basic Shares Outstanding' => [
                    'title' => 'Weighted Average Basic Shares Outstanding',
                    'mapping' => [
                        'self' => 'is_0550',
                        'yoy_change' => 'is_0560',
                    ],
                ],
                'income_statement||Basic EPS: As Reported' => [
                    'title' => 'Basic EPS: As Reported',
                    'mapping' => [
                        'self' => 'is_0960',
                    ],
                ],
                'income_statement||Dividends per share' => [
                    'title' => 'Dividends per share',
                    'type' => 'line',
                    'yAxis' => 'ratio',
                    'mapping' => [
                        'self' => 'is_0590',
                        'yoy_change' => 'is_0600',
                    ],
                ],
                'income_statement||EBITDA' => [
                    'title' => 'EBITDA',
                    'mapping' => [
                        'self' => 'is_0630',
                        'yoy_change' => 'is_0640',
                    ],
                ],
                'income_statement||Interest & Investment Income' => [
                    'title' => 'Interest & Investment Income',
                    'mapping' => [
                        'self' => 'is_0210',
                    ],
                ],
                'income_statement||Currency Exchange Gains (Loss)' => [
                    'title' => 'Currency Exchange Gains (Loss)',
                    'mapping' => [],
                ],
                'income_statement||Income (Loss) On Equity Invest.' => [
                    'title' => 'Income (Loss) On Equity Invest.',
                    'mapping' => [],
                ],
                'income_statement||Other Non Operating Income (Expenses)' => [
                    'title' => 'Other Non Operating Income (Expenses)',
                    'mapping' => [
                        'self' => 'is_0240',
                    ],
                ],
                'income_statement||Merger & Restructuring Charges' => [
                    'title' => 'Merger & Restructuring Charges',
                    'mapping' => [],
                ],
                'income_statement||Impairment of Goodwill' => [
                    'title' => 'Impairment of Goodwill',
                    'mapping' => [],
                ],
                'income_statement||Gain (Loss) On Sale Of Investments' => [
                    'title' => 'Gain (Loss) On Sale Of Investments',
                    'mapping' => [],
                ],
                'income_statement||Asset Writedown' => [
                    'title' => 'Asset Writedown',
                    'mapping' => [],
                ],
                'income_statement||Legal Settlements' => [
                    'title' => 'Legal Settlements',
                    'mapping' => [],
                ],
                'income_statement||Total Unusual Items' => [
                    'title' => 'Total Unusual Items',
                    'mapping' => [
                        'self' => 'is_0350',
                    ],
                ],
                'income_statement||Special Dividends per Share' => [
                    'title' => 'Special Dividends per Share',
                    'type' => 'line',
                    'yAxis' => 'ratio',
                    'mapping' => [
                        'self' => 'is_0610',
                    ],
                ],
                'income_statement||General and Administrative Expense' => [
                    'title' => 'General and Administrative Expense',
                    'mapping' => [
                        'self' => 'is_0650',
                    ],
                ],
                'income_statement||Selling and Marketing Expense' => [
                    'title' => 'Selling and Marketing Expense',
                    'mapping' => [
                        'self' => 'is_0660',
                    ],
                ],
                'income_statement||Advertising Expense' => [
                    'title' => 'Advertising Expense',
                    'mapping' => [
                        'self' => 'is_0670',
                    ],
                ],
                'income_statement||Revenues: As Reported' => [
                    'title' => 'Revenues: As Reported',
                    'mapping' => [
                        'self' => 'is_0860',
                    ],
                ],
                'income_statement||COGS: As Reported' => [
                    'title' => 'COGS: As Reported',
                    'mapping' => [
                        'self' => 'is_0870',
                    ],
                ],
                'income_statement||SG&A: As Reported' => [
                    'title' => 'SG&A: As Reported',
                    'mapping' => [
                        'self' => 'is_0880',
                    ],
                ],
                'income_statement||R&D: As Reported' => [
                    'title' => 'R&D: As Reported',
                    'mapping' => [
                        'self' => 'is_0890',
                    ],
                ],
                'income_statement||Operating Income: As Reported' => [
                    'title' => 'Operating Income: As Reported',
                    'mapping' => [
                        'self' => 'is_0910',
                    ],
                ],
                'income_statement||Interest Expense: As Reported' => [
                    'title' => 'Interest Expense: As Reported',
                    'mapping' => [
                        'self' => 'is_0920',
                    ],
                ],
                'income_statement||EBT: As Reported' => [
                    'title' => 'EBT: As Reported',
                    'mapping' => [
                        'self' => 'is_0930',
                    ],
                ],
                'income_statement||Taxes: As Reported' => [
                    'title' => 'Taxes: As Reported',
                    'mapping' => [
                        'self' => 'is_0940',
                    ],
                ],
                'income_statement||Net Income: As Reported' => [
                    'title' => 'Net Income: As Reported',
                    'mapping' => [
                        'self' => 'is_0950',
                    ],
                ],
                'income_statement||Diluted EPS: As Reported' => [
                    'title' => 'Diluted EPS: As Reported',
                    'mapping' => [
                        'self' => 'is_0970',
                    ],
                ],
                'income_statement||Basic Shares: As Reported' => [
                    'title' => 'Basic Shares: As Reported',
                    'mapping' => [
                        'self' => 'is_0980',
                    ],
                ],
                'income_statement||Diluted Shares: As Reported' => [
                    'title' => 'Diluted Shares: As Reported',
                    'mapping' => [
                        'self' => 'is_0990',
                    ],
                ],
            ],
        ],
        [
            'title' => 'Balance Sheet',
            'has_children' => true,
            'items' => [
                'Assets' => [
                    'balance_sheet||Total Assets' => [
                        'title' => 'Total Assets',
                        'mapping' => [
                            'self' => 'bs_0320',
                        ],
                    ],
                    'balance_sheet||Cash And Equivalents' => [
                        'title' => 'Cash And Equivalents',
                        'mapping' => [],
                    ],
                    'balance_sheet||Short Term Investments' => [
                        'title' => 'Short Term Investments',
                        'mapping' => [],
                    ],
                    'balance_sheet||Trading Securities' => [
                        'title' => 'Trading Securities',
                        'mapping' => [
                            'self' => 'bs_0030',
                        ],
                    ],
                    'balance_sheet||Total Cash And Short Term Investments' => [
                        'title' => 'Total Cash And Short Term Investments',
                        'mapping' => [],
                    ],
                    'balance_sheet||Accounts Receivable' => [
                        'title' => 'Accounts Receivable',
                        'mapping' => [
                            'self' => 'bs_0050',
                        ],
                    ],
                    'balance_sheet||Other Receivables' => [
                        'title' => 'Other Receivables',
                        'mapping' => [
                            'self' => 'bs_0060',
                        ],
                    ],
                    'balance_sheet||Notes Receivable' => [
                        'title' => 'Notes Receivable',
                        'mapping' => [
                            'self' => 'bs_0070',
                        ],
                    ],
                    'balance_sheet||Total Receivables' => [
                        'title' => 'Total Receivables',
                        'mapping' => [
                            'self' => 'bs_0080',
                        ],
                    ],
                    'balance_sheet||Inventory' => [
                        'title' => 'Inventory',
                        'mapping' => [
                            'self' => 'bs_0090',
                        ],
                    ],
                    'balance_sheet||Prepaid Expenses' => [
                        'title' => 'Prepaid Expenses',
                        'mapping' => [
                            'self' => 'bs_0100',
                        ],
                    ],
                    'balance_sheet||Finance Division Loans and Leases Current' => [
                        'title' => 'Finance Division Loans and Leases Current',
                        'mapping' => [],
                    ],
                    'balance_sheet||Finance Division Other Current Assets' => [
                        'title' => 'Finance Division Other Current Assets',
                        'mapping' => [
                            'self' => 'bs_0120',
                        ],
                    ],
                    'balance_sheet||Loans Held For Sale' => [
                        'title' => 'Loans Held For Sale',
                        'mapping' => [
                            'self' => 'bs_0130',
                        ],
                    ],
                    'balance_sheet||Deferred Tax Assets Current' => [
                        'title' => 'Deferred Tax Assets Current',
                        'mapping' => [],
                    ],
                    'balance_sheet||Restricted Cash' => [
                        'title' => 'Restricted Cash',
                        'mapping' => [
                            'self' => 'bs_0150',
                        ],
                    ],
                    'balance_sheet||Other Current Assets' => [
                        'title' => 'Other Current Assets',
                        'mapping' => [
                            'self' => 'bs_0160',
                        ],
                    ],
                    'balance_sheet||Total Current Assets' => [
                        'title' => 'Total Current Assets',
                        'mapping' => [
                            'self' => 'bs_0170',
                        ],
                    ],
                    'balance_sheet||Gross Property Plant And Equipment' => [
                        'title' => 'Gross Property Plant And Equipment',
                        'mapping' => [],
                    ],
                    'balance_sheet||Accumulated Depreciation' => [
                        'title' => 'Accumulated Depreciation',
                        'mapping' => [
                            'self' => 'bs_0190',
                        ],
                    ],
                    'balance_sheet||Net Property Plant And Equipment' => [
                        'title' => 'Net Property Plant And Equipment',
                        'mapping' => [],
                    ],
                    'balance_sheet||Operating lease (Right-of-Use Asset)' => [
                        'title' => 'Operating lease (Right-of-Use Asset)',
                        'mapping' => [
                            'self' => 'bs_0210',
                        ],
                    ],
                    'balance_sheet||Long-term Investments' => [
                        'title' => 'Long-term Investments',
                        'mapping' => [
                            'self' => 'bs_0220',
                        ],
                    ],
                    'balance_sheet||Goodwill' => [
                        'title' => 'Goodwill',
                        'mapping' => [
                            'self' => 'bs_0230',
                        ],
                    ],
                    'balance_sheet||Other Intangibles' => [
                        'title' => 'Other Intangibles',
                        'mapping' => [
                            'self' => 'bs_0240',
                        ],
                    ],
                    'balance_sheet||Finance Division Loans and Leases Long-Term' => [
                        'title' => 'Finance Division Loans and Leases Long-Term',
                        'mapping' => [
                            'self' => 'bs_0250',
                        ],
                    ],
                    'balance_sheet||Finance Division Other Long-Term Assets' => [
                        'title' => 'Finance Division Other Long-Term Assets',
                        'mapping' => [
                            'self' => 'bs_0260',
                        ],
                    ],
                    'balance_sheet||Accounts Receivable Long-Term' => [
                        'title' => 'Accounts Receivable Long-Term',
                        'mapping' => [
                            'self' => 'bs_0270',
                        ],
                    ],
                    'balance_sheet||Loans Receivable Long-Term' => [
                        'title' => 'Loans Receivable Long-Term',
                        'mapping' => [
                            'self' => 'bs_0280',
                        ],
                    ],
                    'balance_sheet||Deferred Tax Assets Long-Term' => [
                        'title' => 'Deferred Tax Assets Long-Term',
                        'mapping' => [
                            'self' => 'bs_0290',
                        ],
                    ],
                    'balance_sheet||Deferred Charges Long-Term' => [
                        'title' => 'Deferred Charges Long-Term',
                        'mapping' => [],
                    ],
                    'balance_sheet||Other Long-Term Assets' => [
                        'title' => 'Other Long-Term Assets',
                        'mapping' => [
                            'self' => 'bs_0310',
                        ],
                    ],
                ],
                'Liabilities' => [
                    'balance_sheet||Total Liabilities' => [
                        'title' => 'Total Liabilities',
                        'mapping' => [
                            'self' => 'bs_0540',
                        ],
                    ],
                    'balance_sheet||Accounts Payable' => [
                        'title' => 'Accounts Payable',
                        'mapping' => [
                            'self' => 'bs_0340',
                        ],
                    ],
                    'balance_sheet||Accrued Expenses' => [
                        'title' => 'Accrued Expenses',
                        'mapping' => [],
                    ],
                    'balance_sheet||Short-term Borrowings' => [
                        'title' => 'Short-term Borrowings',
                        'mapping' => [
                            'self' => 'bs_0360',
                        ],
                    ],
                    'balance_sheet||Current Portion of Long-Term Debt' => [
                        'title' => 'Current Portion of Long-Term Debt',
                        'mapping' => [
                            'self' => 'bs_0370',
                        ],
                    ],
                    'balance_sheet||Current Portion of Leases' => [
                        'title' => 'Current Portion of Leases',
                        'mapping' => [
                            'self' => 'bs_0380',
                        ],
                    ],
                    'balance_sheet||Finance Division Debt Current' => [
                        'title' => 'Finance Division Debt Current',
                        'mapping' => [
                            'self' => 'bs_0390',
                        ],
                    ],
                    'balance_sheet||Finance Division Other Current Liabilities' => [
                        'title' => 'Finance Division Other Current Liabilities',
                        'mapping' => [
                            'self' => 'bs_0400',
                        ],
                    ],
                    'balance_sheet||Current Income Taxes Payable' => [
                        'title' => 'Current Income Taxes Payable',
                        'mapping' => [],
                    ],
                    'balance_sheet||Unearned Revenue Current' => [
                        'title' => 'Unearned Revenue Current',
                        'mapping' => [],
                    ],
                    'balance_sheet||Deferred Tax Liability Current' => [
                        'title' => 'Deferred Tax Liability Current',
                        'mapping' => [
                            'self' => 'bs_0430',
                        ],
                    ],
                    'balance_sheet||Other Current Liabilities' => [
                        'title' => 'Other Current Liabilities',
                        'mapping' => [
                            'self' => 'bs_0440',
                        ],
                    ],
                    'balance_sheet||Total Current Liabilities' => [
                        'title' => 'Total Current Liabilities',
                        'mapping' => [
                            'self' => 'bs_0450',
                        ],
                    ],
                    'balance_sheet||Long-Term Debt' => [
                        'title' => 'Long-Term Debt',
                        'mapping' => [
                            'self' => 'bs_0460',
                        ],
                    ],
                    'balance_sheet||Long-Term Leases' => [
                        'title' => 'Long-Term Leases',
                        'mapping' => [
                            'self' => 'bs_0470',
                        ],
                    ],
                    'balance_sheet||Finance Division Debt Non Current' => [
                        'title' => 'Finance Division Debt Non Current',
                        'mapping' => [
                            'self' => 'bs_0480',
                        ],
                    ],
                    'balance_sheet||Finance Division Other Non Current Liabilities' => [
                        'title' => 'Finance Division Other Non Current Liabilities',
                        'mapping' => [
                            'self' => 'bs_0490',
                        ],
                    ],
                    'balance_sheet||Unearned Revenue Non Current' => [
                        'title' => 'Unearned Revenue Non Current',
                        'mapping' => [],
                    ],
                    'balance_sheet||Pension & Other Post Retirement Benefits' => [
                        'title' => 'Pension & Other Post Retirement Benefits',
                        'mapping' => [
                            'self' => 'bs_0510',
                        ],
                    ],
                    'balance_sheet||Deferred Tax Liability Non Current' => [
                        'title' => 'Deferred Tax Liability Non Current',
                        'mapping' => [],
                    ],
                    'balance_sheet||Other Non Current Liabilities' => [
                        'title' => 'Other Non Current Liabilities',
                        'mapping' => [
                            'self' => 'bs_0530',
                        ],
                    ],
                ],
                'Equity' => [
                    'balance_sheet||Total Equity' => [
                        'title' => 'Total Equity',
                        'mapping' => [
                            'self' => 'bs_0690',
                        ],
                    ],
                    'balance_sheet||Total Liabilities And Equity' => [
                        'title' => 'Total Liabilities And Equity',
                        'mapping' => [
                            'self' => 'bs_0710',
                        ],
                    ],
                    'balance_sheet||Preferred Stock Redeemable' => [
                        'title' => 'Preferred Stock Redeemable',
                        'mapping' => [
                            'self' => 'bs_0560',
                        ],
                    ],
                    'balance_sheet||Preferred Stock Non Redeemable' => [
                        'title' => 'Preferred Stock Non Redeemable',
                        'mapping' => [
                            'self' => 'bs_0570',
                        ],
                    ],
                    'balance_sheet||Preferred Stock Convertible' => [
                        'title' => 'Preferred Stock Convertible',
                        'mapping' => [
                            'self' => 'bs_0580',
                        ],
                    ],
                    'balance_sheet||Preferred Stock - Others' => [
                        'title' => 'Preferred Stock - Others',
                        'mapping' => [
                            'self' => 'bs_0590',
                        ],
                    ],
                    'balance_sheet||Total Preferred Equity' => [
                        'title' => 'Total Preferred Equity',
                        'mapping' => [
                            'self' => 'bs_0600',
                        ],
                    ],
                    'balance_sheet||Common Stock' => [
                        'title' => 'Common Stock',
                        'mapping' => [
                            'self' => 'bs_0610',
                        ],
                    ],
                    'balance_sheet||Additional Paid In Capital' => [
                        'title' => 'Additional Paid In Capital',
                        'mapping' => [
                            'self' => 'bs_0620',
                        ],
                    ],
                    'balance_sheet||Retained Earnings' => [
                        'title' => 'Retained Earnings',
                        'mapping' => [
                            'self' => 'bs_0630',
                        ],
                    ],
                    'balance_sheet||Treasury Stock' => [
                        'title' => 'Treasury Stock',
                        'mapping' => [
                            'self' => 'bs_0640',
                        ],
                    ],
                    'balance_sheet||Comprehensive Income and Other' => [
                        'title' => 'Comprehensive Income and Other',
                        'mapping' => [],
                    ],
                    'balance_sheet||Total Common Equity' => [
                        'title' => 'Total Common Equity',
                        'mapping' => [
                            'self' => 'bs_0670',
                        ],
                    ],
                    'balance_sheet||Minority Interest' => [
                        'title' => 'Minority Interest',
                        'mapping' => [
                            'self' => 'bs_0680',
                        ],
                    ],
                ],
                'Supplementary Data' => [
                    'balance_sheet||Total Shares Out. on Filing Date' => [
                        'title' => 'Total Shares Out. on Filing Date',
                        'mapping' => [
                            'self' => 'bs_0740',
                        ],
                    ],
                    'balance_sheet||Book Value / Share' => [
                        'title' => 'Book Value / Share',
                        'mapping' => [
                            'self' => 'bs_0750',
                        ],
                    ],
                    'balance_sheet||Tangible Book Value' => [
                        'title' => 'Tangible Book Value',
                        'mapping' => [
                            'self' => 'bs_0760',
                        ],
                    ],
                    'balance_sheet||Tangible Book Value / Share' => [
                        'title' => 'Tangible Book Value / Share',
                        'mapping' => [
                            'self' => 'bs_0770',
                        ],
                    ],
                    'balance_sheet||Total Debt' => [
                        'title' => 'Total Debt',
                        'mapping' => [
                            'self' => 'bs_0780',
                        ],
                    ],
                    'balance_sheet||Net Debt' => [
                        'title' => 'Net Debt',
                        'mapping' => [
                            'self' => 'bs_0790',
                        ],
                    ],
                    'balance_sheet||Total Debt inc. Capital Leases' => [
                        'title' => 'Total Debt inc. Capital Leases',
                        'mapping' => [
                            'self' => 'bs_0800',
                        ],
                    ],
                    'balance_sheet||Total Net Debt inc. Cap Leases' => [
                        'title' => 'Total Net Debt inc. Cap Leases',
                        'mapping' => [
                            'self' => 'bs_0810',
                        ],
                    ],
                    'balance_sheet||Total Minority Interest' => [
                        'title' => 'Total Minority Interest',
                        'mapping' => [
                            'self' => 'bs_0820',
                        ],
                    ],
                    'balance_sheet||Equity Method Investments' => [
                        'title' => 'Equity Method Investments',
                        'mapping' => [
                            'self' => 'bs_0830',
                        ],
                    ],
                    'balance_sheet||Land' => [
                        'title' => 'Land',
                        'mapping' => [
                            'self' => 'bs_0840',
                        ],
                    ],
                    'balance_sheet||Buildings' => [
                        'title' => 'Buildings',
                        'mapping' => [
                            'self' => 'bs_0850',
                        ],
                    ],
                    'balance_sheet||Leasehold Improvements' => [
                        'title' => 'Leasehold Improvements',
                        'mapping' => [
                            'self' => 'bs_0860',
                        ],
                    ],
                    'balance_sheet||Construction In Progress' => [
                        'title' => 'Construction In Progress',
                        'mapping' => [
                            'self' => 'bs_0870',
                        ],
                    ],
                    'balance_sheet||Full Time Employees' => [
                        'title' => 'Full Time Employees',
                        'mapping' => [
                            'self' => 'bs_0880',
                        ],
                    ],
                ],
            ],
        ],
        [
            'title' => 'Cash Flow',
            'has_children' => true,
            'items' => [
                'CF Operations' => [
                    'cash_flow||Cash Flow from Operations' => [
                        'title' => 'Cash Flow from Operations',
                        'mapping' => [
                            'self' => 'cf_0310',
                        ],
                    ],
                    'cash_flow||Total Changes in Net Working Capital' => [
                        'title' => 'Total Changes in Net Working Capital',
                        'mapping' => [
                            'self' => 'cf_0290',
                        ],
                    ],
                    'cash_flow||Net Income' => [
                        'title' => 'Net Income',
                        'mapping' => [
                            'self' => 'cf_0010',
                        ],
                    ],
                    'cash_flow||Depreciation & Amortization' => [
                        'title' => 'Depreciation & Amortization',
                        'mapping' => [
                            'self' => 'cf_0020',
                        ],
                    ],
                    'cash_flow||Amortization of Goodwill and Intangible Assets' => [
                        'title' => 'Amortization of Goodwill and Intangible Assets',
                        'mapping' => [
                            'self' => 'cf_0030',
                        ],
                    ],
                    'cash_flow||Total Depreciation & Amortization' => [
                        'title' => 'Total Depreciation & Amortization',
                        'mapping' => [
                            'self' => 'cf_0040',
                        ],
                    ],
                    'cash_flow||Amortization of Deferred Charges' => [
                        'title' => 'Amortization of Deferred Charges',
                        'mapping' => [
                            'self' => 'cf_0050',
                        ],
                    ],
                    'cash_flow||Minority Interest in Earnings' => [
                        'title' => 'Minority Interest in Earnings',
                        'mapping' => [
                            'self' => 'cf_0060',
                        ],
                    ],
                    'cash_flow||(Gain) Loss From Sale Of Asset' => [
                        'title' => '(Gain) Loss From Sale Of Asset',
                        'mapping' => [
                            'self' => 'cf_0070',
                        ],
                    ],
                    'cash_flow||(Gain) Loss on Sale of Investments' => [
                        'title' => '(Gain) Loss on Sale of Investments',
                        'mapping' => [
                            'self' => 'cf_0080',
                        ],
                    ],
                    'cash_flow||Asset Writedown & Restructuring Costs' => [
                        'title' => 'Asset Writedown & Restructuring Costs',
                        'mapping' => [
                            'self' => 'cf_0090',
                        ],
                    ],
                    'cash_flow||Net (Increase) Decrease in Loans Originated / Sold - Operating' => [
                        'title' => 'Net (Increase) Decrease in Loans Originated / Sold - Operating',
                        'mapping' => [
                            'self' => 'cf_0100',
                        ],
                    ],
                    'cash_flow||Provision for Credit Losses' => [
                        'title' => 'Provision for Credit Losses',
                        'mapping' => [
                            'self' => 'cf_0110',
                        ],
                    ],
                    'cash_flow||(Income) Loss On Equity Investments' => [
                        'title' => '(Income) Loss On Equity Investments',
                        'mapping' => [
                            'self' => 'cf_0120',
                        ],
                    ],
                    'cash_flow||Stock-Based Compensation' => [
                        'title' => 'Stock-Based Compensation',
                        'mapping' => [
                            'self' => 'cf_0130',
                        ],
                    ],
                    'cash_flow||Tax Benefit from Stock Options' => [
                        'title' => 'Tax Benefit from Stock Options',
                        'mapping' => [
                            'self' => 'cf_0140',
                        ],
                    ],
                    'cash_flow||Provision and Write-off of Bad Debts' => [
                        'title' => 'Provision and Write-off of Bad Debts',
                        'mapping' => [
                            'self' => 'cf_0150',
                        ],
                    ],
                    'cash_flow||Net Cash From Discontinued Operations' => [
                        'title' => 'Net Cash From Discontinued Operations',
                        'mapping' => [
                            'self' => 'cf_0160',
                        ],
                    ],
                    'cash_flow||Cash Flow Before Changes in NWC' => [
                        'title' => 'Cash Flow Before Changes in NWC',
                        'mapping' => [
                            'self' => 'cf_0170',
                        ],
                    ],
                    'cash_flow||Change in Trading Asset Securities' => [
                        'title' => 'Change in Trading Asset Securities',
                        'mapping' => [
                            'self' => 'cf_0180',
                        ],
                    ],
                    'cash_flow||Change In Accounts Receivable' => [
                        'title' => 'Change In Accounts Receivable',
                        'mapping' => [
                            'self' => 'cf_0190',
                        ],
                    ],
                    'cash_flow||Change In Inventories' => [
                        'title' => 'Change In Inventories',
                        'mapping' => [
                            'self' => 'cf_0200',
                        ],
                    ],
                    'cash_flow||Change In Accounts Payable' => [
                        'title' => 'Change In Accounts Payable',
                        'mapping' => [
                            'self' => 'cf_0210',
                        ],
                    ],
                    'cash_flow||Change in Unearned Revenues' => [
                        'title' => 'Change in Unearned Revenues',
                        'mapping' => [
                            'self' => 'cf_0220',
                        ],
                    ],
                    'cash_flow||Change In Income Taxes' => [
                        'title' => 'Change In Income Taxes',
                        'mapping' => [
                            'self' => 'cf_0230',
                        ],
                    ],
                    'cash_flow||Change In Deferred Taxes' => [
                        'title' => 'Change In Deferred Taxes',
                        'mapping' => [
                            'self' => 'cf_0240',
                        ],
                    ],
                    'cash_flow||Change In Vendor Non-Trade Receivables' => [
                        'title' => 'Change In Vendor Non-Trade Receivables',
                        'mapping' => [
                            'self' => 'cf_0250',
                        ],
                    ],
                    'cash_flow||Change in Other Current and Non-Current Assets' => [
                        'title' => 'Change in Other Current and Non-Current Assets',
                        'mapping' => [
                            'self' => 'cf_0260',
                        ],
                    ],
                    'cash_flow||Change in Other Current and Non-Current Liabilities' => [
                        'title' => 'Change in Other Current and Non-Current Liabilities',
                        'mapping' => [
                            'self' => 'cf_0270',
                        ],
                    ],
                    'cash_flow||Change in Other Net Operating Assets' => [
                        'title' => 'Change in Other Net Operating Assets',
                        'mapping' => [
                            'self' => 'cf_0280',
                        ],
                    ],
                    'cash_flow||Other Operating Activities' => [
                        'title' => 'Other Operating Activities',
                        'mapping' => [
                            'self' => 'cf_0300',
                        ],
                    ],
                ],
                'CF Investing' => [
                    'cash_flow||Cash Flow from Investing' => [
                        'title' => 'Cash Flow from Investing',
                        'mapping' => [
                            'self' => 'cf_0420',
                        ],
                    ],
                    'cash_flow||Capital Expenditure' => [
                        'title' => 'Capital Expenditure',
                        'mapping' => [
                            'self' => 'cf_0330',
                        ],
                    ],
                    'cash_flow||Sale of Property, Plant, and Equipment' => [
                        'title' => 'Sale of Property, Plant, and Ecash_flow||quipment',
                        'mapping' => [
                            'self' => 'cf_0340',
                        ],
                    ],
                    'cash_flow||Cash Acquisitions' => [
                        'title' => 'Cash Acquisitions',
                        'mapping' => [
                            'self' => 'cf_0350',
                        ],
                    ],
                    'cash_flow||Divestitures' => [
                        'title' => 'Divestitures',
                        'mapping' => [
                            'self' => 'cf_0360',
                        ],
                    ],
                    'cash_flow||Sale (Purchase) of Real Estate properties' => [
                        'title' => 'Sale (Purchase) of Real Ecash_flow||state properties',
                        'mapping' => [
                            'self' => 'cf_0370',
                        ],
                    ],
                    'cash_flow||Sale (Purchase) of Intangible assets' => [
                        'title' => 'Sale (Purchase) of Intangible acash_flow||ssets',
                        'mapping' => [
                            'self' => 'cf_0380',
                        ],
                    ],
                    'cash_flow||Investment in Marketable and Equity Securities' => [
                        'title' => 'Investment in Mcash_flow||arketable and Equity Securities',
                        'mapping' => [
                            'self' => 'cf_0390',
                        ],
                    ],
                    'cash_flow||Net (Increase) Decrease in Loans Originated / Sold - Investing' => [
                        'title' => 'Net (cash_flow||Increase) Decrease in Loans Originated / Sold - Investing',
                        'mapping' => [
                            'self' => 'cf_0400',
                        ],
                    ],
                    'cash_flow||Other Investing Activities' => [
                        'title' => 'Other Investing Activities',
                        'mapping' => [
                            'self' => 'cf_0410',
                        ],
                    ],
                ],
                'CF Financing' => [
                    'cash_flow||Cash Flow from Financing' => [
                        'title' => 'Cash Flow from Financing',
                        'mapping' => [
                            'self' => 'cf_0580',
                        ],
                    ],
                    'cash_flow||Total Debt Issued' => [
                        'title' => 'Total Debt Issued',
                        'mapping' => [
                            'self' => 'cf_0440',
                        ],
                    ],
                    'cash_flow||Total Debt Repaid' => [
                        'title' => 'Total Debt Repaid',
                        'mapping' => [
                            'self' => 'cf_0450',
                        ],
                    ],
                    'cash_flow||Net Debt Issued (Repaid)' => [
                        'title' => 'Net Debt Issued (Repaid)',
                        'mapping' => [
                            'self' => 'cf_0460',
                        ],
                    ],
                    'cash_flow||Issuance of Common Stock' => [
                        'title' => 'Issuance of Common Stock',
                        'mapping' => [
                            'self' => 'cf_0470',
                        ],
                    ],
                    'cash_flow||Repurchase of Common Stock' => [
                        'title' => 'Repurchase of Common Stock',
                        'mapping' => [
                            'self' => 'cf_0480',
                        ],
                    ],
                    'cash_flow||Net Equity Issued (Repurchased)' => [
                        'title' => 'Net Equity Issued (Repurchased)',
                        'mapping' => [
                            'self' => 'cf_0490',
                        ],
                    ],
                    'cash_flow||Issuance of Preferred Stock' => [
                        'title' => 'Issuance of Preferred Stock',
                        'mapping' => [
                            'self' => 'cf_0500',
                        ],
                    ],
                    'cash_flow||Repurchase of Preferred Stock' => [
                        'title' => 'Repurchase of Preferred Stock',
                        'mapping' => [
                            'self' => 'cf_0510',
                        ],
                    ],
                    'cash_flow||Net Preferred Stock Issued (Repurchased)' => [
                        'title' => 'Net Preferred Stock Issued (Repurchased)',
                        'mapping' => [
                            'self' => 'cf_0520',
                        ],
                    ],
                    'cash_flow||Common Dividends Paid' => [
                        'title' => 'Common Dividends Paid',
                        'mapping' => [
                            'self' => 'cf_0530',
                        ],
                    ],
                    'cash_flow||Preferred Dividends Paid' => [
                        'title' => 'Preferred Dividends Paid',
                        'mapping' => [
                            'self' => 'cf_0540',
                        ],
                    ],
                    'cash_flow||Special Dividend Paid' => [
                        'title' => 'Special Dividend Paid',
                        'mapping' => [
                            'self' => 'cf_0550',
                        ],
                    ],
                    'cash_flow||Total Dividends Paid' => [
                        'title' => 'Total Dividends Paid',
                        'mapping' => [
                            'self' => 'cf_0560',
                        ],
                    ],
                    'cash_flow||Other Financing Activities' => [
                        'title' => 'Other Financing Activities',
                        'mapping' => [
                            'self' => 'cf_0570',
                        ],
                    ],
                ],
                'Supplementary Data' => [
                    'cash_flow||Levered Free Cash Flow' => [
                        'title' => 'Levered Free Cash Flow',
                        'mapping' => [
                            'self' => 'cf_0700',
                            'yoy_change' => 'cf_0710',
                        ],
                    ],
                    'cash_flow||LFCF per Share' => [
                        'title' => 'LFCF per Share',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [],
                    ],
                    'cash_flow||Unlevered Free Cash Flow' => [
                        'title' => 'Unlevered Free Cash Flow',
                        'mapping' => [
                            'self' => 'cf_0750',
                            'yoy_change' => 'cf_0760',
                        ],
                    ],
                    'cash_flow||Foreign Exchange Rate Adjustments' => [
                        'title' => 'Foreign Exchange Rate Adjustments',
                        'mapping' => [
                            'self' => 'cf_0600',
                        ],
                    ],
                    'cash_flow||Miscellaneous Cash Flow Adjustments' => [
                        'title' => 'Miscellaneous Cash Flow Adjustments',
                        'mapping' => [
                            'self' => 'cf_0610',
                        ],
                    ],
                    'cash_flow||Net Change in Cash' => [
                        'title' => 'Net Change in Cash',
                        'mapping' => [
                            'self' => 'cf_0620',
                        ],
                    ],
                    'cash_flow||Cash and Cash Equivalents, Beginning of Period' => [
                        'title' => 'Cash and Cash Equivalents, Beginning of Period',
                        'mapping' => [
                            'self' => 'cf_0650',
                        ],
                    ],
                    'cash_flow||Cash and Cash Equivalents, End of Period' => [
                        'title' => 'Cash and Cash Equivalents, End of Period',
                        'mapping' => [
                            'self' => 'cf_0660',
                        ],
                    ],
                    'cash_flow||Cash Interest Paid' => [
                        'title' => 'Cash Interest Paid',
                        'mapping' => [
                            'self' => 'cf_0670',
                        ],
                    ],
                    'cash_flow||Cash Taxes Paid' => [
                        'title' => 'Cash Taxes Paid',
                        'mapping' => [
                            'self' => 'cf_0680',
                        ],
                    ],
                ],
            ],
        ],
        [
            'title' => 'Ratios',
            'has_children' => true,
            'items' => [
                'Return Ratios' => [
                    'ratios||Return on Assets % (ROA)' => [
                        'title' => 'Return on Assets % (ROA)',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0020',
                        ],
                    ],
                    'ratios||Return on Invested Capital % (ROIC)' => [
                        'title' => 'Return on Invested Capital % (ROIC)',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0030',
                        ],
                    ],
                    'ratios||Return On Equity % (ROE)' => [
                        'title' => 'Return On Equity % (ROE)',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0040',
                        ],
                    ],
                    'ratios||Return on Common Equity %' => [
                        'title' => 'Return on Common Equity %',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0050',
                        ],
                    ],
                    'ratios||Return on Tangible Capital (ROTC)' => [
                        'title' => 'Return on Tangible Capital (ROTC)',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0060',
                        ],
                    ],
                    'ratios||Return on Incremental Invested Capital (ROIIC)' => [
                        'title' => 'Return on Incremental Invested Capital (ROIIC)',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0070',
                        ],
                    ],
                ],
                'Margin Analysis' => [
                    'ratios||Gross Profit Margin %' => [
                        'title' => 'Gross Profit Margin %',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0100',
                        ],
                    ],
                    'ratios||SG&A Margin %' => [
                        'title' => 'SG&A Margin %',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0110',
                        ],
                    ],
                    'ratios||R&D Margin %' => [
                        'title' => 'R&D Margin %',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0120',
                        ],
                    ],
                    'ratios||EBIT Margin %' => [
                        'title' => 'EBIT Margin %',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0130',
                        ],
                    ],
                    'ratios||EBITDA Margin %' => [
                        'title' => 'EBITDA Margin %',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0140',
                        ],
                    ],
                    'ratios||Net Income Margin %' => [
                        'title' => 'Net Income Margin %',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0150',
                        ],
                    ],
                    'ratios||EBITA Margin %' => [
                        'title' => 'EBITA Margin %',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0160',
                        ],
                    ],
                    'ratios||EBT Margin %' => [
                        'title' => 'EBT Margin %',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0170',
                        ],
                    ],
                    'ratios||Levered Free Cash Flow Margin %' => [
                        'title' => 'Levered Free Cash Flow Margin %',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0180',
                        ],
                    ],
                    'ratios||Unlevered Free Cash Flow Margin %' => [
                        'title' => 'Unlevered Free Cash Flow Margin %',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0190',
                        ],
                    ],
                ],
                'Turnover' => [
                    'ratios||Asset Turnover' => [
                        'title' => 'Asset Turnover',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0220',
                        ],
                    ],
                    'ratios||Fixed Assets Turnover' => [
                        'title' => 'Fixed Assets Turnover',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0230',
                        ],
                    ],
                    'ratios||Receivables Turnover' => [
                        'title' => 'Receivables Turnover',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0240',
                        ],
                    ],
                    'ratios||Inventory Turnover' => [
                        'title' => 'Inventory Turnover',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0250',
                        ],
                    ],
                ],
                'Liquidity' => [
                    'ratios||Current Ratio' => [
                        'title' => 'Current Ratio',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0280',
                        ],
                    ],
                    'ratios||Quick Ratio' => [
                        'title' => 'Quick Ratio',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0290',
                        ],
                    ],
                    'ratios||Dividend Payout Ratio' => [
                        'title' => 'Dividend Payout Ratio',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0300',
                        ],
                    ],
                    'ratios||Op Cash Flow to Current Liab' => [
                        'title' => 'Op Cash Flow to Current Liab',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0310',
                        ],
                    ],
                    'ratios||Avg. Days Sales Outstanding' => [
                        'title' => 'Avg. Days Sales Outstanding',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0320',
                        ],
                    ],
                    'ratios||Avg. Days Outstanding Inventory' => [
                        'title' => 'Avg. Days Outstanding Inventory',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0330',
                        ],
                    ],
                    'ratios||Avg. Days Payable Outstanding' => [
                        'title' => 'Avg. Days Payable Outstanding',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0340',
                        ],
                    ],
                    'ratios||Avg. Cash Conversion Cycle' => [
                        'title' => 'Avg. Cash Conversion Cycle',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0350',
                        ],
                    ],
                ],
                'Solvency' => [
                    'ratios||Total Debt / Equity' => [
                        'title' => 'Total Debt / Equity',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0380',
                        ],
                    ],
                    'ratios||Total Debt / Capital' => [
                        'title' => 'Total Debt / Capital',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0390',
                        ],
                    ],
                    'ratios||Total Liabilities / Total Assets' => [
                        'title' => 'Total Liabilities / Total Assets',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0400',
                        ],
                    ],
                    'ratios||Total Assets / Total Equity' => [
                        'title' => 'Total Assets / Total Equity',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0410',
                        ],
                    ],
                    'ratios||Average Assets / Average Equity' => [
                        'title' => 'Average Assets / Average Equity',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0420',
                        ],
                    ],
                    'ratios||EBIT / Interest Expense' => [
                        'title' => 'EBIT / Interest Expense',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0430',
                        ],
                    ],
                    'ratios||EBITDA / Interest Expense' => [
                        'title' => 'EBITDA / Interest Expense',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0440',
                        ],
                    ],
                    'ratios||(EBITDA - Capex) / Interest Expense' => [
                        'title' => '(EBITDA - Capex) / Interest Expense',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0450',
                        ],
                    ],
                    'ratios||Total Debt / EBITDA' => [
                        'title' => 'Total Debt / EBITDA',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0460',
                        ],
                    ],
                    'ratios||Net Debt / EBITDA' => [
                        'title' => 'Net Debt / EBITDA',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0470',
                        ],
                    ],
                    'ratios||Net Debt / (EBITDA - Capex)' => [
                        'title' => 'Net Debt / (EBITDA - Capex)',
                        'type' => 'line',
                        'yAxis' => 'ratio',
                        'mapping' => [
                            'self' => 'ra_0480',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'table-builder' => [
        'summaries' => [
            'Max',
            'Min',
            'Sum',
            'Median',
        ]
    ],
    'unitTypes' => [
        'Thousands',
        'Millions',
        'Billions',
    ]
];
