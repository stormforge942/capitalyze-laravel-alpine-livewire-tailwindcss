<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use App\Models\InfoTikrPresentation;
use Illuminate\Support\Facades\Cache;

class TableBuilderService
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
                'title' => 'Income Statement',
                'has_children' => false,
                'items' => [
                    'income_statement||Total Revenues' => [
                        'title' => 'Total Revenue',
                    ],
                    'income_statement||Cost of Goods Sold' => [
                        'title' => 'Cost of Goods Sold',
                    ],
                    'income_statement||Total Gross Profit' => [
                        'title' => 'Total Gross Profit',
                    ],
                    'income_statement||SG&A Expenses' => [
                        'title' => 'SG&A Expenses',
                    ],
                    'income_statement||R&D Expenses' => [
                        'title' => 'R&D Expenses',
                    ],
                    'income_statement||Interest Expense' => [
                        'title' => 'Interest Expense',
                    ],
                    'income_statement||EBT - Excluding Unusual Items' => [
                        'title' => 'EBT - Excluding Unusual Items',
                    ],
                    'income_statement||Earnings Before Taxes (EBT)' => [
                        'title' => 'Earnings Before Taxes (EBT)',
                    ],
                    'income_statement||Income Tax Expense' => [
                        'title' => 'Income Tax Expense',
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
                    'income_statement||Weighted Avg. Diluted Shares Outstanding' => [
                        'title' => 'Weighted Avg. Diluted Shares Outstanding',
                    ],
                    'income_statement||Diluted Earnings Per Share' => [
                        'title' => 'Diluted Earnings Per Share',
                    ],
                    'income_statement||Weighted Average Basic Shares Outstanding' => [
                        'title' => 'Weighted Average Basic Shares Outstanding',
                    ],
                    'income_statement||Basic EPS: As Reported' => [
                        'title' => 'Basic EPS: As Reported',
                    ],
                    'income_statement||Dividends per share' => [
                        'title' => 'Dividends per share',
                    ],
                    'income_statement||EBITDA' => [
                        'title' => 'EBITDA',
                    ],
                    'income_statement||Interest & Investment Income' => [
                        'title' => 'Interest & Investment Income',
                    ],
                    'income_statement||Currency Exchange Gains (Loss)' => [
                        'title' => 'Currency Exchange Gains (Loss)',
                    ],
                    'income_statement||Income (Loss) On Equity Invest.' => [
                        'title' => 'Income (Loss) On Equity Invest.',
                    ],
                    'income_statement||Other Non Operating Income (Expenses)' => [
                        'title' => 'Other Non Operating Income (Expenses)',
                    ],
                    'income_statement||Merger & Restructuring Charges' => [
                        'title' => 'Merger & Restructuring Charges',
                    ],
                    'income_statement||Impairment of Goodwill' => [
                        'title' => 'Impairment of Goodwill',
                    ],
                    'income_statement||Gain (Loss) On Sale Of Investments' => [
                        'title' => 'Gain (Loss) On Sale Of Investments',
                    ],
                    'income_statement||Asset Writedown' => [
                        'title' => 'Asset Writedown',
                    ],
                    'income_statement||Legal Settlements' => [
                        'title' => 'Legal Settlements',
                    ],
                    'income_statement||Total Unusual Items' => [
                        'title' => 'Total Unusual Items',
                    ],
                    'income_statement||Special Dividends per Share' => [
                        'title' => 'Special Dividends per Share',
                    ],
                    'income_statement||General and Administrative Expense' => [
                        'title' => 'General and Administrative Expense',
                    ],
                    'income_statement||Selling and Marketing Expense' => [
                        'title' => 'Selling and Marketing Expense',
                    ],
                    'income_statement||Advertising Expense' => [
                        'title' => 'Advertising Expense',
                    ],
                    'income_statement||Revenues: As Reported' => [
                        'title' => 'Revenues: As Reported',
                    ],
                    'income_statement||COGS: As Reported' => [
                        'title' => 'COGS: As Reported',
                    ],
                    'income_statement||SG&A: As Reported' => [
                        'title' => 'SG&A: As Reported',
                    ],
                    'income_statement||R&D: As Reported' => [
                        'title' => 'R&D: As Reported',
                    ],
                    'income_statement||Operating Income: As Reported' => [
                        'title' => 'Operating Income: As Reported',
                    ],
                    'income_statement||Interest Expense: As Reported' => [
                        'title' => 'Interest Expense: As Reported',
                    ],
                    'income_statement||EBT: As Reported' => [
                        'title' => 'EBT: As Reported',
                    ],
                    'income_statement||Taxes: As Reported' => [
                        'title' => 'Taxes: As Reported',
                    ],
                    'income_statement||Net Income: As Reported' => [
                        'title' => 'Net Income: As Reported',
                    ],
                    'income_statement||Basic EPS: As Reported' => [
                        'title' => 'Basic EPS: As Reported',
                    ],
                    'income_statement||Diluted EPS: As Reported' => [
                        'title' => 'Diluted EPS: As Reported',
                    ],
                    'income_statement||Basic Shares: As Reported' => [
                        'title' => 'Basic Shares: As Reported',
                    ],
                    'income_statement||Diluted Shares: As Reported' => [
                        'title' => 'Diluted Shares: As Reported',
                    ],
                ]
            ],
            [
                'title' => 'Balance Sheet',
                'has_children' => true,
                'items' => [
                    'Assets' => [
                        "balance_sheet||Total Assets" => [
                            'title' => 'Total Assets'
                        ],
                        "balance_sheet||Cash And Equivalents" => [
                            'title' => 'Cash And Equivalents'
                        ],
                        "balance_sheet||Short Term Investments" => [
                            'title' => 'Short Term Investments'
                        ],
                        "balance_sheet||Trading Securities" => [
                            'title' => 'Trading Securities'
                        ],
                        "balance_sheet||Total Cash And Short Term Investments" => [
                            'title' => 'Total Cash And Short Term Investments'
                        ],
                        "balance_sheet||Accounts Receivable" => [
                            'title' => 'Accounts Receivable'
                        ],
                        "balance_sheet||Other Receivables" => [
                            'title' => 'Other Receivables'
                        ],
                        "balance_sheet||Notes Receivable" => [
                            'title' => 'Notes Receivable'
                        ],
                        "balance_sheet||Total Receivables" => [
                            'title' => 'Total Receivables'
                        ],
                        "balance_sheet||Inventory" => [
                            'title' => 'Inventory'
                        ],
                        "balance_sheet||Prepaid Expenses" => [
                            'title' => 'Prepaid Expenses'
                        ],
                        "balance_sheet||Finance Division Loans and Leases Current" => [
                            'title' => 'Finance Division Loans and Leases Current'
                        ],
                        "balance_sheet||Finance Division Other Current Assets" => [
                            'title' => 'Finance Division Other Current Assets'
                        ],
                        "balance_sheet||Loans Held For Sale" => [
                            'title' => 'Loans Held For Sale'
                        ],
                        "balance_sheet||Deferred Tax Assets Current" => [
                            'title' => 'Deferred Tax Assets Current'
                        ],
                        "balance_sheet||Restricted Cash" => [
                            'title' => 'Restricted Cash'
                        ],
                        "balance_sheet||Other Current Assets" => [
                            'title' => 'Other Current Assets'
                        ],
                        "balance_sheet||Total Current Assets" => [
                            'title' => 'Total Current Assets'
                        ],
                        "balance_sheet||Gross Property Plant And Equipment" => [
                            'title' => 'Gross Property Plant And Equipment'
                        ],
                        "balance_sheet||Accumulated Depreciation" => [
                            'title' => 'Accumulated Depreciation'
                        ],
                        "balance_sheet||Net Property Plant And Equipment" => [
                            'title' => 'Net Property Plant And Equipment'
                        ],
                        "balance_sheet||Operating lease (Right-of-Use Asset)" => [
                            'title' => 'Operating lease (Right-of-Use Asset)'
                        ],
                        "balance_sheet||Long-term Investments" => [
                            'title' => 'Long-term Investments'
                        ],
                        "balance_sheet||Goodwill" => [
                            'title' => 'Goodwill'
                        ],
                        "balance_sheet||Other Intangibles" => [
                            'title' => 'Other Intangibles'
                        ],
                        "balance_sheet||Finance Division Loans and Leases Long-Term" => [
                            'title' => 'Finance Division Loans and Leases Long-Term'
                        ],
                        "balance_sheet||Finance Division Other Long-Term Assets" => [
                            'title' => 'Finance Division Other Long-Term Assets'
                        ],
                        "balance_sheet||Accounts Receivable Long-Term" => [
                            'title' => 'Accounts Receivable Long-Term'
                        ],
                        "balance_sheet||Loans Receivable Long-Term" => [
                            'title' => 'Loans Receivable Long-Term'
                        ],
                        "balance_sheet||Deferred Tax Assets Long-Term" => [
                            'title' => 'Deferred Tax Assets Long-Term'
                        ],
                        "balance_sheet||Deferred Charges Long-Term" => [
                            'title' => 'Deferred Charges Long-Term'
                        ],
                        "balance_sheet||Other Long-Term Assets" => [
                            'title' => 'Other Long-Term Assets'
                        ],
                    ],
                    'Liabilities' => [
                        'balance_sheet||Total Liabilities' => [
                            'title' => 'Total Liabilities'
                        ],
                        'balance_sheet||Accounts Payable' => [
                            'title' => 'Accounts Payable'
                        ],
                        'balance_sheet||Accrued Expenses' => [
                            'title' => 'Accrued Expenses'
                        ],
                        'balance_sheet||Short-term Borrowings' => [
                            'title' => 'Short-term Borrowings'
                        ],
                        'balance_sheet||Current Portion of Long-Term Debt' => [
                            'title' => 'Current Portion of Long-Term Debt'
                        ],
                        'balance_sheet||Current Portion of Leases' => [
                            'title' => 'Current Portion of Leases'
                        ],
                        'balance_sheet||Finance Division Debt Current' => [
                            'title' => 'Finance Division Debt Current'
                        ],
                        'balance_sheet||Finance Division Other Current Liabilities' => [
                            'title' => 'Finance Division Other Current Liabilities'
                        ],
                        'balance_sheet||Current Income Taxes Payable' => [
                            'title' => 'Current Income Taxes Payable'
                        ],
                        'balance_sheet||Unearned Revenue Current' => [
                            'title' => 'Unearned Revenue Current'
                        ],
                        'balance_sheet||Deferred Tax Liability Current' => [
                            'title' => 'Deferred Tax Liability Current'
                        ],
                        'balance_sheet||Other Current Liabilities' => [
                            'title' => 'Other Current Liabilities'
                        ],
                        'balance_sheet||Total Current Liabilities' => [
                            'title' => 'Total Current Liabilities'
                        ],
                        'balance_sheet||Long-Term Debt' => [
                            'title' => 'Long-Term Debt'
                        ],
                        'balance_sheet||Long-Term Leases' => [
                            'title' => 'Long-Term Leases'
                        ],
                        'balance_sheet||Finance Division Debt Non Current' => [
                            'title' => 'Finance Division Debt Non Current'
                        ],
                        'balance_sheet||Finance Division Other Non Current Liabilities' => [
                            'title' => 'Finance Division Other Non Current Liabilities'
                        ],
                        'balance_sheet||Unearned Revenue Non Current' => [
                            'title' => 'Unearned Revenue Non Current'
                        ],
                        'balance_sheet||Pension & Other Post Retirement Benefits' => [
                            'title' => 'Pension & Other Post Retirement Benefits'
                        ],
                        'balance_sheet||Deferred Tax Liability Non Current' => [
                            'title' => 'Deferred Tax Liability Non Current'
                        ],
                        'balance_sheet||Other Non Current Liabilities' => [
                            'title' => 'Other Non Current Liabilities'
                        ],
                    ],
                    'Equity' => [
                        'balance_sheet||Total Equity' => [
                            'title' => 'Total Equity'
                        ],
                        'balance_sheet||Total Liabilities And Equity' => [
                            'title' => 'Total Liabilities And Equity'
                        ],
                        'balance_sheet||Preferred Stock Redeemable' => [
                            'title' => 'Preferred Stock Redeemable'
                        ],
                        'balance_sheet||Preferred Stock Non Redeemable' => [
                            'title' => 'Preferred Stock Non Redeemable'
                        ],
                        'balance_sheet||Preferred Stock Convertible' => [
                            'title' => 'Preferred Stock Convertible'
                        ],
                        'balance_sheet||Preferred Stock - Others' => [
                            'title' => 'Preferred Stock - Others'
                        ],
                        'balance_sheet||Total Preferred Equity' => [
                            'title' => 'Total Preferred Equity'
                        ],
                        'balance_sheet||Common Stock' => [
                            'title' => 'Common Stock'
                        ],
                        'balance_sheet||Additional Paid In Capital' => [
                            'title' => 'Additional Paid In Capital'
                        ],
                        'balance_sheet||Retained Earnings' => [
                            'title' => 'Retained Earnings'
                        ],
                        'balance_sheet||Treasury Stock' => [
                            'title' => 'Treasury Stock'
                        ],
                        'balance_sheet||Comprehensive Income and Other' => [
                            'title' => 'Comprehensive Income and Other'
                        ],
                        'balance_sheet||Total Common Equity' => [
                            'title' => 'Total Common Equity'
                        ],
                        'balance_sheet||Minority Interest' => [
                            'title' => 'Minority Interest'
                        ],
                    ],
                    'Supplementary Data' => [
                        'balance_sheet||Total Shares Out. on Filing Date' => [
                            'title' => 'Total Shares Out. on Filing Date'
                        ],
                        'balance_sheet||Book Value / Share' => [
                            'title' => 'Book Value / Share'
                        ],
                        'balance_sheet||Tangible Book Value' => [
                            'title' => 'Tangible Book Value'
                        ],
                        'balance_sheet||Tangible Book Value / Share' => [
                            'title' => 'Tangible Book Value / Share'
                        ],
                        'balance_sheet||Total Debt' => [
                            'title' => 'Total Debt'
                        ],
                        'balance_sheet||Net Debt' => [
                            'title' => 'Net Debt'
                        ],
                        'balance_sheet||Total Debt inc. Capital Leases' => [
                            'title' => 'Total Debt inc. Capital Leases'
                        ],
                        'balance_sheet||Total Net Debt inc. Cap Leases' => [
                            'title' => 'Total Net Debt inc. Cap Leases'
                        ],
                        'balance_sheet||Total Minority Interest' => [
                            'title' => 'Total Minority Interest'
                        ],
                        'balance_sheet||Equity Method Investments' => [
                            'title' => 'Equity Method Investments'
                        ],
                        'balance_sheet||Land' => [
                            'title' => 'Land'
                        ],
                        'balance_sheet||Buildings' => [
                            'title' => 'Buildings'
                        ],
                        'balance_sheet||Leasehold Improvements' => [
                            'title' => 'Leasehold Improvements'
                        ],
                        'balance_sheet||Construction In Progress' => [
                            'title' => 'Construction In Progress'
                        ],
                        'balance_sheet||Full Time Employees' => [
                            'title' => 'Full Time Employees'
                        ],
                    ]
                ]
            ],
            [
                'title' => 'Cash Flow',
                'has_children' => true,
                'items' => [
                    'CF Operations' => [
                        'cash_flow||Cash Flow from Operations' => [
                            'title' => 'Cash Flow from Operations'
                        ],
                        'cash_flow||Total Changes in Net Working Capital' => [
                            'title' => 'Total Changes in Net Working Capital'
                        ],
                        'cash_flow||Net Income' => [
                            'title' => 'Net Income'
                        ],
                        'cash_flow||Depreciation & Amortization' => [
                            'title' => 'Depreciation & Amortization'
                        ],
                        'cash_flow||Amortization of Goodwill and Intangible Assets' => [
                            'title' => 'Amortization of Goodwill and Intangible Assets'
                        ],
                        'cash_flow||Total Depreciation & Amortization' => [
                            'title' => 'Total Depreciation & Amortization'
                        ],
                        'cash_flow||Amortization of Deferred Charges' => [
                            'title' => 'Amortization of Deferred Charges'
                        ],
                        'cash_flow||Minority Interest in Earnings' => [
                            'title' => 'Minority Interest in Earnings'
                        ],
                        'cash_flow||(Gain) Loss From Sale Of Asset' => [
                            'title' => '(Gain) Loss From Sale Of Asset'
                        ],
                        'cash_flow||(Gain) Loss on Sale of Investments' => [
                            'title' => '(Gain) Loss on Sale of Investments'
                        ],
                        'cash_flow||Asset Writedown & Restructuring Costs' => [
                            'title' => 'Asset Writedown & Restructuring Costs'
                        ],
                        'cash_flow||Net (Increase) Decrease in Loans Originated / Sold - Operating' => [
                            'title' => 'Net (Increase) Decrease in Loans Originated / Sold - Operating'
                        ],
                        'cash_flow||Provision for Credit Losses' => [
                            'title' => 'Provision for Credit Losses'
                        ],
                        'cash_flow||(Income) Loss On Equity Investments' => [
                            'title' => '(Income) Loss On Equity Investments'
                        ],
                        'cash_flow||Stock-Based Compensation' => [
                            'title' => 'Stock-Based Compensation'
                        ],
                        'cash_flow||Tax Benefit from Stock Options' => [
                            'title' => 'Tax Benefit from Stock Options'
                        ],
                        'cash_flow||Provision and Write-off of Bad Debts' => [
                            'title' => 'Provision and Write-off of Bad Debts'
                        ],
                        'cash_flow||Net Cash From Discontinued Operations' => [
                            'title' => 'Net Cash From Discontinued Operations'
                        ],
                        'cash_flow||Cash Flow Before Changes in NWC' => [
                            'title' => 'Cash Flow Before Changes in NWC'
                        ],
                        'cash_flow||Change in Trading Asset Securities' => [
                            'title' => 'Change in Trading Asset Securities'
                        ],
                        'cash_flow||Change In Accounts Receivable' => [
                            'title' => 'Change In Accounts Receivable'
                        ],
                        'cash_flow||Change In Inventories' => [
                            'title' => 'Change In Inventories'
                        ],
                        'cash_flow||Change In Accounts Payable' => [
                            'title' => 'Change In Accounts Payable'
                        ],
                        'cash_flow||Change in Unearned Revenues' => [
                            'title' => 'Change in Unearned Revenues'
                        ],
                        'cash_flow||Change In Income Taxes' => [
                            'title' => 'Change In Income Taxes'
                        ],
                        'cash_flow||Change In Deferred Taxes' => [
                            'title' => 'Change In Deferred Taxes'
                        ],
                        'cash_flow||Change In Vendor Non-Trade Receivables' => [
                            'title' => 'Change In Vendor Non-Trade Receivables'
                        ],
                        'cash_flow||Change in Other Current and Non-Current Assets' => [
                            'title' => 'Change in Other Current and Non-Current Assets'
                        ],
                        'cash_flow||Change in Other Current and Non-Current Liabilities' => [
                            'title' => 'Change in Other Current and Non-Current Liabilities'
                        ],
                        'cash_flow||Change in Other Net Operating Assets' => [
                            'title' => 'Change in Other Net Operating Assets'
                        ],
                        'cash_flow||Other Operating Activities' => [
                            'title' => 'Other Operating Activities'
                        ],
                    ],
                    'CF Investing' => [
                        'cash_flow||Cash Flow from Investing' => [
                            'title' => 'Cash Flow from Investing'
                        ],
                        'cash_flow||Capital Expenditure' => [
                            'title' => 'Capital Expenditure'
                        ],
                        'Sale of Property, Plant, and Equipment' => [
                            'title' => 'Sale of Property, Plant, and Ecash_flow||quipment'
                        ],
                        'cash_flow||Cash Acquisitions' => [
                            'title' => 'Cash Acquisitions'
                        ],
                        'cash_flow||Divestitures' => [
                            'title' => 'Divestitures'
                        ],
                        'Sale (Purchase) of Real Estate properties' => [
                            'title' => 'Sale (Purchase) of Real Ecash_flow||state properties'
                        ],
                        'Sale (Purchase) of Intangible assets' => [
                            'title' => 'Sale (Purchase) of Intangible acash_flow||ssets'
                        ],
                        'Investment in Marketable and Equity Securities' => [
                            'title' => 'Investment in Mcash_flow||arketable and Equity Securities'
                        ],
                        'Net (Increase) Decrease in Loans Originated / Sold - Investing' => [
                            'title' => 'Net (cash_flow||Increase) Decrease in Loans Originated / Sold - Investing'
                        ],
                        'cash_flow||Other Investing Activities' => [
                            'title' => 'Other Investing Activities'
                        ],
                    ],
                    'CF Financing' => [
                        'cash_flow||Cash Flow from Financing' => [
                            'title' => 'Cash Flow from Financing'
                        ],
                        'cash_flow||Total Debt Issued' => [
                            'title' => 'Total Debt Issued'
                        ],
                        'cash_flow||Total Debt Repaid' => [
                            'title' => 'Total Debt Repaid'
                        ],
                        'cash_flow||Net Debt Issued (Repaid)' => [
                            'title' => 'Net Debt Issued (Repaid)'
                        ],
                        'cash_flow||Issuance of Common Stock' => [
                            'title' => 'Issuance of Common Stock'
                        ],
                        'cash_flow||Repurchase of Common Stock' => [
                            'title' => 'Repurchase of Common Stock'
                        ],
                        'cash_flow||Net Equity Issued (Repurchased)' => [
                            'title' => 'Net Equity Issued (Repurchased)'
                        ],
                        'cash_flow||Issuance of Preferred Stock' => [
                            'title' => 'Issuance of Preferred Stock'
                        ],
                        'cash_flow||Repurchase of Preferred Stock' => [
                            'title' => 'Repurchase of Preferred Stock'
                        ],
                        'cash_flow||Net Preferred Stock Issued (Repurchased)' => [
                            'title' => 'Net Preferred Stock Issued (Repurchased)'
                        ],
                        'cash_flow||Common Dividends Paid' => [
                            'title' => 'Common Dividends Paid'
                        ],
                        'cash_flow||Preferred Dividends Paid' => [
                            'title' => 'Preferred Dividends Paid'
                        ],
                        'cash_flow||Special Dividend Paid' => [
                            'title' => 'Special Dividend Paid'
                        ],
                        'cash_flow||Total Dividends Paid' => [
                            'title' => 'Total Dividends Paid'
                        ],
                        'cash_flow||Other Financing Activities' => [
                            'title' => 'Other Financing Activities'
                        ],
                    ],
                    'Supplementary Data' => [
                        'cash_flow||Levered Free Cash Flow' => [
                            'title' => 'Levered Free Cash Flow'
                        ],
                        'cash_flow||LFCF per Share' => [
                            'title' => 'LFCF per Share'
                        ],
                        'cash_flow||Unlevered Free Cash Flow' => [
                            'title' => 'Unlevered Free Cash Flow'
                        ],
                        'cash_flow||Foreign Exchange Rate Adjustments' => [
                            'title' => 'Foreign Exchange Rate Adjustments'
                        ],
                        'cash_flow||Miscellaneous Cash Flow Adjustments' => [
                            'title' => 'Miscellaneous Cash Flow Adjustments'
                        ],
                        'cash_flow||Net Change in Cash' => [
                            'title' => 'Net Change in Cash'
                        ],
                        'cash_flow||Cash and Cash Equivalents, Beginning of Period' => [
                            'title' => 'Cash and Cash Equivalents, Beginning of Period'
                        ],
                        'cash_flow||Cash and Cash Equivalents, End of Period' => [
                            'title' => 'Cash and Cash Equivalents, End of Period'
                        ],
                        'cash_flow||Cash Interest Paid' => [
                            'title' => 'Cash Interest Paid'
                        ],
                        'cash_flow||Cash Taxes Paid' => [
                            'title' => 'Cash Taxes Paid'
                        ],
                    ]
                ]
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
                        ],
                        'ratios||Return on Invested Capital % (ROIC)' => [
                            'title' => 'Return on Invested Capital % (ROIC)',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||Return On Equity % (ROE)' => [
                            'title' => 'Return On Equity % (ROE)',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||Return on Common Equity %' => [
                            'title' => 'Return on Common Equity %',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||Return on Tangible Capital (ROTC)' => [
                            'title' => 'Return on Tangible Capital (ROTC)',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||Return on Incremental Invested Capital (ROIIC)' => [
                            'title' => 'Return on Incremental Invested Capital (ROIIC)',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                    ],
                    'Margin Analysis' => [
                        'ratios||Gross Profit Margin %' => [
                            'title' => 'Gross Profit Margin %',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||SG&A Margin %' => [
                            'title' => 'SG&A Margin %',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||R&D Margin %' => [
                            'title' => 'R&D Margin %',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||EBIT Margin %' => [
                            'title' => 'EBIT Margin %',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||EBITDA Margin %' => [
                            'title' => 'EBITDA Margin %',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||Net Income Margin %' => [
                            'title' => 'Net Income Margin %',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||EBITA Margin %' => [
                            'title' => 'EBITA Margin %',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||EBT Margin %' => [
                            'title' => 'EBT Margin %',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||Levered Free Cash Flow Margin %' => [
                            'title' => 'Levered Free Cash Flow Margin %',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||Unlevered Free Cash Flow Margin %' => [
                            'title' => 'Unlevered Free Cash Flow Margin %',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                    ],
                    'Turnover' => [
                        'ratios||Asset Turnover' => [
                            'title' => 'Asset Turnover',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||Fixed Assets Turnover' => [
                            'title' => 'Fixed Assets Turnover',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||Receivables Turnover' => [
                            'title' => 'Receivables Turnover',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||Inventory Turnover' => [
                            'title' => 'Inventory Turnover',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                    ],
                    'Liquidity' => [
                        'ratios||Current Ratio' => [
                            'title' => 'Current Ratio',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||Quick Ratio' => [
                            'title' => 'Quick Ratio',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||Dividend Payout Ratio' => [
                            'title' => 'Dividend Payout Ratio',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||Op Cash Flow to Current Liab' => [
                            'title' => 'Op Cash Flow to Current Liab',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||Avg. Days Sales Outstanding' => [
                            'title' => 'Avg. Days Sales Outstanding',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||Avg. Days Outstanding Inventory' => [
                            'title' => 'Avg. Days Outstanding Inventory',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||Avg. Days Payable Outstanding' => [
                            'title' => 'Avg. Days Payable Outstanding',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||Avg. Cash Conversion Cycle' => [
                            'title' => 'Avg. Cash Conversion Cycle',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                    ],
                    'Solvency' => [
                        'ratios||Total Debt / Equity' => [
                            'title' => 'Total Debt / Equity',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||Total Debt / Capital' => [
                            'title' => 'Total Debt / Capital',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||Total Liabilities / Total Assets' => [
                            'title' => 'Total Liabilities / Total Assets',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||Total Assets / Total Equity' => [
                            'title' => 'Total Assets / Total Equity',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||Average Assets / Average Equity' => [
                            'title' => 'Average Assets / Average Equity',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||EBIT / Interest Expense' => [
                            'title' => 'EBIT / Interest Expense',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||EBITDA / Interest Expense' => [
                            'title' => 'EBITDA / Interest Expense',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||(EBITDA - Capex) / Interest Expense' => [
                            'title' => '(EBITDA - Capex) / Interest Expense',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||Total Debt / EBITDA' => [
                            'title' => 'Total Debt / EBITDA',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||Net Debt / EBITDA' => [
                            'title' => 'Net Debt / EBITDA',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                        'ratios||Net Debt / (EBITDA - Capex)' => [
                            'title' => 'Net Debt / (EBITDA - Capex)',
                            'type' => 'line',
                            'yAxis' => 'ratio',
                        ],
                    ]
                ]
            ]
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

    public static function resolveData($companies, $metrics)
    {
        $periods = ['annual', 'quarter'];

        $data = array_reduce($periods, function ($c, $i) use ($companies) {
            $c[$i] = array_reduce($companies, function ($d, $j) {
                $d[$j] = [];
                return $d;
            }, []);
            return $c;
        }, []);

        $standardKeys = [];
        foreach ($metrics as $metric) {
            [$column, $key] = explode('||', $metric, 2);

            if (!isset($standardKeys[$column])) {
                $standardKeys[$column] = [];
            }

            $standardKeys[$column][] = $key;
        }

        if (empty($standardKeys) || !count($companies)) {
            return null;
        }

        $cacheKey = 'table_builder_' . md5(implode(',', $companies) . implode(',', array_keys($standardKeys)));

        $standardData = Cache::remember(
            $cacheKey,
            3600,
            fn () => InfoTikrPresentation::query()
                ->whereIn('ticker', $companies)
                ->select(['ticker', 'period', ...array_keys($standardKeys)])
                ->get()
                ->groupBy('period')
        );

        foreach ($standardData as $period => $items) {
            if (!in_array($period, $periods)) {
                continue;
            }

            foreach ($items as $item) {
                foreach ($standardKeys as $column => $keys) {
                    $json = json_decode($item->{$column}, true);

                    foreach ($json as $key => $_value) {
                        $key = explode('|', $key)[0];

                        if (!in_array($key, $keys)) {
                            continue;
                        }

                        $value = [];

                        foreach ($_value as $date => $v) {
                            $val = explode('|', $v[0])[0];
                            $value[$date] = $val ? round((float) $val, 3) : null;
                        }

                        $key = $column . '||' . $key;

                        $data[$period][$item->ticker][$key] = self::normalizeValue($value, $period);
                    }
                }

                // sort metrics by order
                uksort($data[$period][$item->ticker], fn ($a, $b) => array_search($a, $metrics) - array_search($b, $metrics));
            }

            // sort companies by order
            uksort($data[$period], fn ($a, $b) => array_search($a, $companies) - array_search($b, $companies));
        }

        $dates = self::extractDates($data);

        return [
            'data' => $data,
            'dates' => $dates,
        ];
    }

    private static function normalizeValue(array $value, string $period): array
    {
        $val = [];

        foreach ($value as $date => $v) {
            $date = Carbon::parse($date);

            $key = $period === 'quarter'
                ? $date->year . ' Q' . $date->quarter
                : 'FY ' . $date->year;

            $val[$key] = $v;
        }

        return $val;
    }

    private static function extractDates(array $data): array
    {
        $dates = array_reduce(['annual', 'quarter'], function ($c, $i) {
            $c[$i] = [];
            return $c;
        }, []);

        foreach ($data as $period => $item) {
            foreach ($item as $metrics) {
                foreach ($metrics as $values) {
                    $dates[$period] = array_merge($dates[$period], array_keys($values));
                }
            }
        }

        foreach ($dates as $period => $value) {
            $dates[$period] = array_unique($value);
            sort($dates[$period]);
        }

        return $dates;
    }
}
