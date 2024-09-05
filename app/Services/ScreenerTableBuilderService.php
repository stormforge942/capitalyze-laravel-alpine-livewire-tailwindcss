<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use App\Models\InfoTikrPresentation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ScreenerTableBuilderService
{
    protected $filterFieldsMap = [
        'locations' => 'country',
        'industries' => 'sic_group',
        'sectors' => 'sic_description',
        'stockExchanges' => 'exchange'
    ];

    public static function options($flattened = false)
    {
        $options = [
            [
                'title' => 'Income Statement',
                'items' => [
                    'income_statement||Total Revenues' => [
                        'title' => 'Total Revenue',
                    ],
                    'income_statement||Cost of Goods Sold' => [
                        'title' => 'Cost of Goods Sold',
                    ],
                    'income_statement||Total Gross Profits' => [
                        'title' => 'Total Gross Profits',
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
                        'type' => 'ratio',
                    ],
                    'income_statement||Weighted Average Basic Shares Outstanding' => [
                        'title' => 'Weighted Average Basic Shares Outstanding',
                    ],
                    'income_statement||Basic EPS: As Reported' => [
                        'title' => 'Basic EPS: As Reported',
                    ],
                    'income_statement||Dividends per share' => [
                        'title' => 'Dividends per share',
                        'type' => 'ratio',
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
                'items' => [
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
            ],
            [
                'title' => 'Cash Flow',
                'items' => [
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
                    'cash_flow||Levered Free Cash Flow' => [
                        'title' => 'Levered Free Cash Flow'
                    ],
                    'cash_flow||LFCF per Share' => [
                        'title' => 'LFCF per Share',
                        'type' => 'ratio',
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
            ],
            [
                'title' => 'Ratios',
                'items' => [
                    'ratios||Return on Assets % (ROA)' => [
                        'title' => 'Return on Assets % (ROA)',
                        'type' => 'ratio',
                    ],
                    'ratios||Return on Invested Capital % (ROIC)' => [
                        'title' => 'Return on Invested Capital % (ROIC)',
                        'type' => 'ratio',
                    ],
                    'ratios||Return On Equity % (ROE)' => [
                        'title' => 'Return On Equity % (ROE)',
                        'type' => 'ratio',
                    ],
                    'ratios||Return on Common Equity %' => [
                        'title' => 'Return on Common Equity %',
                        'type' => 'ratio',
                    ],
                    'ratios||Return on Tangible Capital (ROTC)' => [
                        'title' => 'Return on Tangible Capital (ROTC)',
                        'type' => 'ratio',
                    ],
                    'ratios||Return on Incremental Invested Capital (ROIIC)' => [
                        'title' => 'Return on Incremental Invested Capital (ROIIC)',
                        'type' => 'ratio',
                    ],
                    'ratios||Gross Profit Margin %' => [
                        'title' => 'Gross Profit Margin %',
                        'type' => 'ratio',
                    ],
                    'ratios||SG&A Margin %' => [
                        'title' => 'SG&A Margin %',
                        'type' => 'ratio',
                    ],
                    'ratios||R&D Margin %' => [
                        'title' => 'R&D Margin %',
                        'type' => 'ratio',
                    ],
                    'ratios||EBIT Margin %' => [
                        'title' => 'EBIT Margin %',
                        'type' => 'ratio',
                    ],
                    'ratios||EBITDA Margin %' => [
                        'title' => 'EBITDA Margin %',
                        'type' => 'ratio',
                    ],
                    'ratios||Net Income Margin %' => [
                        'title' => 'Net Income Margin %',
                        'type' => 'ratio',
                    ],
                    'ratios||EBITA Margin %' => [
                        'title' => 'EBITA Margin %',
                        'type' => 'ratio',
                    ],
                    'ratios||EBT Margin %' => [
                        'title' => 'EBT Margin %',
                        'type' => 'ratio',
                    ],
                    'ratios||Levered Free Cash Flow Margin %' => [
                        'title' => 'Levered Free Cash Flow Margin %',
                        'type' => 'ratio',
                    ],
                    'ratios||Unlevered Free Cash Flow Margin %' => [
                        'title' => 'Unlevered Free Cash Flow Margin %',
                        'type' => 'ratio',
                    ],
                    'ratios||Asset Turnover' => [
                        'title' => 'Asset Turnover',
                        'type' => 'ratio',
                    ],
                    'ratios||Fixed Assets Turnover' => [
                        'title' => 'Fixed Assets Turnover',
                        'type' => 'ratio',
                    ],
                    'ratios||Receivables Turnover' => [
                        'title' => 'Receivables Turnover',
                        'type' => 'ratio',
                    ],
                    'ratios||Inventory Turnover' => [
                        'title' => 'Inventory Turnover',
                        'type' => 'ratio',
                    ],
                    'ratios||Current Ratio' => [
                        'title' => 'Current Ratio',
                        'type' => 'ratio',
                    ],
                    'ratios||Quick Ratio' => [
                        'title' => 'Quick Ratio',
                        'type' => 'ratio',
                    ],
                    'ratios||Dividend Payout Ratio' => [
                        'title' => 'Dividend Payout Ratio',
                        'type' => 'ratio',
                    ],
                    'ratios||Op Cash Flow to Current Liab' => [
                        'title' => 'Op Cash Flow to Current Liab',
                        'type' => 'ratio',
                    ],
                    'ratios||Avg. Days Sales Outstanding' => [
                        'title' => 'Avg. Days Sales Outstanding',
                        'type' => 'ratio',
                    ],
                    'ratios||Avg. Days Outstanding Inventory' => [
                        'title' => 'Avg. Days Outstanding Inventory',
                        'type' => 'ratio',
                    ],
                    'ratios||Avg. Days Payable Outstanding' => [
                        'title' => 'Avg. Days Payable Outstanding',
                        'type' => 'ratio',
                    ],
                    'ratios||Avg. Cash Conversion Cycle' => [
                        'title' => 'Avg. Cash Conversion Cycle',
                        'type' => 'ratio',
                    ],
                    'ratios||Total Debt / Equity' => [
                        'title' => 'Total Debt / Equity',
                        'type' => 'ratio',
                    ],
                    'ratios||Total Debt / Capital' => [
                        'title' => 'Total Debt / Capital',
                        'type' => 'ratio',
                    ],
                    'ratios||Total Liabilities / Total Assets' => [
                        'title' => 'Total Liabilities / Total Assets',
                        'type' => 'ratio',
                    ],
                    'ratios||Total Assets / Total Equity' => [
                        'title' => 'Total Assets / Total Equity',
                        'type' => 'ratio',
                    ],
                    'ratios||Average Assets / Average Equity' => [
                        'title' => 'Average Assets / Average Equity',
                        'type' => 'ratio',
                    ],
                    'ratios||EBIT / Interest Expense' => [
                        'title' => 'EBIT / Interest Expense',
                        'type' => 'ratio',
                    ],
                    'ratios||EBITDA / Interest Expense' => [
                        'title' => 'EBITDA / Interest Expense',
                        'type' => 'ratio',
                    ],
                    'ratios||(EBITDA - Capex) / Interest Expense' => [
                        'title' => '(EBITDA - Capex) / Interest Expense',
                        'type' => 'ratio',
                    ],
                    'ratios||Total Debt / EBITDA' => [
                        'title' => 'Total Debt / EBITDA',
                        'type' => 'ratio',
                    ],
                    'ratios||Net Debt / EBITDA' => [
                        'title' => 'Net Debt / EBITDA',
                        'type' => 'ratio',
                    ],
                    'ratios||Net Debt / (EBITDA - Capex)' => [
                        'title' => 'Net Debt / (EBITDA - Capex)',
                        'type' => 'ratio',
                    ],
                ],
            ]
        ];

        if (!$flattened) {
            return $options;
        }

        $flattenedOptions = [];

        foreach ($options as $option) {
            foreach ($option['items'] as $key => $item) {
                $flattenedOptions[$key] = $item;
            }
        }

        return $flattenedOptions;
    }

    public static function resolveData($companies, $page = 1)
    {
        if (!count($companies)) {
            return [
                'data' => [],
                'dates' => [],
                'paginator' => null
            ];
        }

        $_companies = $companies;
        sort($_companies);

        $data = [];

        $columns = ['income_statement', 'balance_sheet', 'cash_flow', 'ratios'];

        $periods = ['annual', 'quarter'];

        $datePlaceholders = array_reduce($columns, function ($carry, $item) {
            $carry[$item] = [];
            return $carry;
        }, []);

        $dates = array_reduce($periods, function ($carry, $item) use ($datePlaceholders) {
            $carry[$item] = $datePlaceholders;
            return $carry;
        }, []);

        $paginator = InfoTikrPresentation::query()
            ->whereIn('ticker', $companies)
            ->whereIn('period', $periods)
            ->select(['ticker', 'period', ...$columns])
            ->paginate(30, ['*'], 'page', $page)
        ;

        $standartData = collect($paginator->items())->groupBy('period');

        foreach ($standartData as $period => $items) {
            $min = now()->year;
            $max = 0;

            foreach ($items as $item) {
                foreach ($columns as $column) {
                    $json = json_decode($item->{$column}, true);

                    foreach ($json as $key => $_value) {
                        $key = explode('|', $key)[0];

                        $value = [];

                        foreach ($_value as $date => $v) {
                            $date = Carbon::parse($date);

                            $min = $date->year < $min ? $date->year : $min;
                            $max = $date->year > $max ? $date->year : $max;

                            $v_key = $period === 'quarter'
                                ? 'Q' . $date->quarter . ' ' . $date->year
                                : 'FY ' . $date->year;

                            $val = explode('|', $v[0])[0];
                            $value[$v_key] = is_numeric($val) ? round((float) $val, 3) : null;
                        }

                        $dates[$period][$column] = array_unique(array_merge($dates[$period][$column], array_keys($value)));

                        $key = $column . '||' . $key;

                        $data[$item->ticker][$key] = array_merge(
                            $data[$item->ticker][$key] ?? [],
                            $value
                        );
                    }
                }
            }

            // sort companies by order
            uksort($data, fn ($a, $b) => array_search($a, $companies) - array_search($b, $companies));
        }

        return [
            'data' => $data,
            'dates' => $dates,
            'paginator' => $paginator
        ];

    }

    public function resolveDataTest($universeCriteria = null, $financialCriteria = null)
    {
        $selects = [];
        $joins = [];
        $groupBys = ['r.ticker', 'p.registrant_name', 'p.country', 'p.sic_group', 'p.sic_description', 'p.exchange'];
        $calculations = [];
        $cteTableQueries= [];
        $filters = [];
        $counters = [];

        $universeCriteriaWeres = $this->makeUniverseCriteriaFilterString($universeCriteria);

        foreach ($financialCriteria as $criterion) {
            $formatedCriterion = $criterion['value'][0] ?? $criterion;
            $metricData = explode('||', $formatedCriterion['metric']);
            $period = $formatedCriterion['period'];
            $currentDateData = $this->getCurrentDate($formatedCriterion['dates'][0]);
            $previousDateData = $this->getPreviousDate($formatedCriterion['dates'][0]);
            $columnType = $this->getColumnType($formatedCriterion['type']);
            $comparisonExpression = null;
            $filterExpression = null;

            $jsonFieldName = $metricData[0];
            $metricName = $metricData[1];

            $attributeName = 'attr' . uniqid();
            $innerCurrentDateAttributeName = 'inner_attr' . uniqid();
            $innerPreviousDateAttributeName = 'inner_attr' . uniqid();
            $cteTableName = 'cte_table_name_' . uniqid();

            $columnName = $metricName . '\n' . $columnType . ' ' . $currentDateData['initialDate'];

            switch ($formatedCriterion['type']) {
                case $formatedCriterion['type'] ==='value' && $period === 'annual':
                    $cteTableQueries[] = DB::raw("
                        {$cteTableName} AS (
                            SELECT
                                ticker,
                                period,
                                MAX(CASE
                                    WHEN date_part('year', {$innerCurrentDateAttributeName}.key::date) = {$currentDateData['year']} THEN
                                        TRIM(BOTH '\"' FROM split_part(
                                            REPLACE(REPLACE({$innerCurrentDateAttributeName}.value::text, '[\"', ''), '\"]', ''),
                                            '|',
                                            1
                                        ))
                                    ELSE NULL
                                END) AS \"{$columnName}\"
                            FROM public.info_tikr_presentations r
                            JOIN jsonb_each_text(r.{$jsonFieldName}::jsonb) AS $attributeName(key, value) ON {$attributeName}.key ILIKE '%$metricName%'
                            JOIN jsonb_each_text({$attributeName}.value::jsonb) AS {$innerCurrentDateAttributeName}(key, value) ON (
                                date_part('year', {$innerCurrentDateAttributeName}.key::date) = {$currentDateData['year']}
                            )
                            WHERE period = '{$period}'
                            GROUP BY ticker, period
                        )
                    ");

                    if (isset($formatedCriterion['comparisonValue'])) {
                        $comparisonExpression = $this->getComparisonExpression($formatedCriterion['comparisonValue'], $formatedCriterion['type']);
                        $filterExpression = $cteTableName . "." . "\"{$columnName}\"::numeric" . ' ' . $comparisonExpression;
                    }

                    if (!empty($filterExpression)) {
                        $filters[] = $filterExpression;
                    }

                    if (!empty($comparisonExpression)) {
                        $counters[] = "COUNT(CASE WHEN \"{$columnName}\"::numeric {$comparisonExpression} THEN 1 ELSE NULL END) OVER () AS \"counter_{$criterion['id']}\"";
                    }

                    $selects[] = $cteTableName . "." . "\"{$columnName}\"";
                    $joins[] = "LEFT JOIN {$cteTableName} ON p.symbol = {$cteTableName}.ticker";
                    $groupBys[] = $cteTableName. "." . "\"{$columnName}\"";

                    break;
                case $formatedCriterion['type'] === 'value' && $period === 'quarter':
                    $cteTableQueries[] = DB::raw("
                        {$cteTableName} AS (
                            SELECT
                                ticker,
                                period,
                                MAX(CASE
                                    WHEN date_part('year', {$innerCurrentDateAttributeName}.key::date) = {$currentDateData['year']} AND date_part('quarter', {$innerCurrentDateAttributeName}.key::date) = {$currentDateData['quarter']} THEN
                                        TRIM(BOTH '\"' FROM split_part(
                                            REPLACE(REPLACE({$innerCurrentDateAttributeName}.value::text, '[\"', ''), '\"]', ''),
                                            '|',
                                            1
                                        ))
                                    ELSE NULL
                                END) AS \"{$columnName}\"
                            FROM public.info_tikr_presentations r
                            JOIN jsonb_each_text(r.{$jsonFieldName}::jsonb) AS $attributeName(key, value) ON {$attributeName}.key ILIKE '%$metricName%'
                            JOIN jsonb_each_text({$attributeName}.value::jsonb) AS {$innerCurrentDateAttributeName}(key, value) ON (
                                date_part('year', {$innerCurrentDateAttributeName}.key::date) = {$currentDateData['year']}
                                AND date_part('quarter', {$innerCurrentDateAttributeName}.key::date) = {$currentDateData['quarter']}
                            )
                            WHERE period = '{$period}'
                            GROUP BY ticker, period
                        )
                    ");

                    if (isset($formatedCriterion['comparisonValue'])) {
                        $comparisonExpression = $this->getComparisonExpression($formatedCriterion['comparisonValue'], $formatedCriterion['type']);
                        $filterExpression = $cteTableName . "." . "\"{$columnName}\"::numeric" . ' ' . $comparisonExpression;
                    }

                    if (!empty($filterExpression)) {
                        $filters[] = $filterExpression;
                    }

                    if (!empty($comparisonExpression)) {
                        $counters[] = "COUNT(CASE WHEN \"{$columnName}\"::numeric {$comparisonExpression} THEN 1 ELSE NULL END) OVER () AS \"counter_{$criterion['id']}\"";
                    }

                    $selects[] = $cteTableName . "." . "\"{$columnName}\"";
                    $joins[] = "LEFT JOIN {$cteTableName} ON p.symbol = {$cteTableName}.ticker";
                    $groupBys[] = $cteTableName. "." . "\"{$columnName}\"";

                    break;
                case $formatedCriterion['type'] === 'growth' && $period === 'annual':
                    $firstTmpColumn = 'tmp_column_' . uniqid();
                    $secondTmpColumn = 'tmp_column_' . uniqid();

                    $cteTableQueries[] = DB::raw("
                        {$cteTableName} AS (
                            SELECT
                                ticker,
                                period,
                                MAX(CASE
                                    WHEN date_part('year', {$innerCurrentDateAttributeName}.key::date) = {$currentDateData['year']} THEN
                                        TRIM(BOTH '\"' FROM split_part(
                                            REPLACE(REPLACE({$innerCurrentDateAttributeName}.value::text, '[\"', ''), '\"]', ''),
                                            '|',
                                            1
                                        ))
                                    ELSE NULL
                                END) AS \"{$firstTmpColumn}\",

                                MAX(CASE
                                    WHEN date_part('year', {$innerPreviousDateAttributeName}.key::date) = {$previousDateData['year']} THEN
                                        TRIM(BOTH '\"' FROM split_part(
                                            REPLACE(REPLACE({$innerPreviousDateAttributeName}.value::text, '[\"', ''), '\"]', ''),
                                            '|',
                                            1
                                        ))
                                    ELSE NULL
                                END) AS \"{$secondTmpColumn}\"

                            FROM public.info_tikr_presentations r
                            JOIN jsonb_each_text(r.{$jsonFieldName}::jsonb) AS $attributeName(key, value) ON {$attributeName}.key ILIKE '%$metricName%'
                            JOIN jsonb_each_text({$attributeName}.value::jsonb) AS {$innerCurrentDateAttributeName}(key, value) ON (
                                date_part('year', {$innerCurrentDateAttributeName}.key::date) = {$currentDateData['year']}
                            )
                            JOIN jsonb_each_text({$attributeName}.value::jsonb) AS {$innerPreviousDateAttributeName}(key, value) ON (
                                date_part('year', {$innerPreviousDateAttributeName}.key::date) = {$previousDateData['year']}
                            )
                            WHERE period = '{$period}'
                            GROUP BY ticker, period
                        )
                    ");

                    if (isset($formatedCriterion['comparisonValue'])) {
                        $comparisonExpression = $this->getComparisonExpression($formatedCriterion['comparisonValue'], $formatedCriterion['type']);

                        $filterExpression = "
                        CASE
                            WHEN MAX(\"{$firstTmpColumn}\"::numeric) != 0 THEN
                                MAX(\"{$secondTmpColumn}\"::numeric) / MAX(\"{$firstTmpColumn}\"::numeric)
                            ELSE NULL
                         END " . $comparisonExpression;
                    }

                    if (!empty($filterExpression)) {
                        $filters[] = $filterExpression;
                    }

                    if (!empty($comparisonExpression)) {
                        $counters[] = "COUNT(CASE WHEN \"{$columnName}\"::numeric {$comparisonExpression} THEN 1 ELSE NULL END) OVER () AS \"counter_{$criterion['id']}\"";
                    }

                    $calculations[] = "
                        CASE
                            WHEN MAX({$firstTmpColumn}::numeric) != 0  THEN
                                MAX({$secondTmpColumn}::numeric) / MAX({$firstTmpColumn}::numeric)
                            ELSE NULL
                        END AS \"{$columnName}\"
                    ";
                    $joins[] = "LEFT JOIN {$cteTableName} ON p.symbol = {$cteTableName}.ticker";

                    break;
                case $formatedCriterion['type'] === 'growth' && $period === 'quarter':
                    $firstTmpColumn = 'tmp_column_' . uniqid();
                    $secondTmpColumn = 'tmp_column_' . uniqid();

                    $cteTableQueries[] = DB::raw("
                        {$cteTableName} AS (
                            SELECT
                                ticker,
                                period,
                                MAX(CASE
                                    WHEN date_part('year', {$innerCurrentDateAttributeName}.key::date) = {$currentDateData['year']} AND date_part('quarter', {$innerCurrentDateAttributeName}.key::date) = {$currentDateData['quarter']} THEN
                                        TRIM(BOTH '\"' FROM split_part(
                                            REPLACE(REPLACE({$innerCurrentDateAttributeName}.value::text, '[\"', ''), '\"]', ''),
                                            '|',
                                            1
                                        ))
                                    ELSE NULL
                                END) AS \"{$firstTmpColumn}\",

                                MAX(CASE
                                    WHEN date_part('year', {$innerPreviousDateAttributeName}.key::date) = {$previousDateData['year']} AND date_part('quarter', {$innerPreviousDateAttributeName}.key::date) = {$previousDateData['quarter']} THEN
                                        TRIM(BOTH '\"' FROM split_part(
                                            REPLACE(REPLACE({$innerPreviousDateAttributeName}.value::text, '[\"', ''), '\"]', ''),
                                            '|',
                                            1
                                        ))
                                    ELSE NULL
                                END) AS \"{$secondTmpColumn}\"

                            FROM public.info_tikr_presentations r
                            JOIN jsonb_each_text(r.{$jsonFieldName}::jsonb) AS $attributeName(key, value) ON {$attributeName}.key ILIKE '%$metricName%'
                            JOIN jsonb_each_text({$attributeName}.value::jsonb) AS {$innerCurrentDateAttributeName}(key, value) ON (
                                date_part('year', {$innerCurrentDateAttributeName}.key::date) = {$currentDateData['year']}
                                AND date_part('quarter', {$innerCurrentDateAttributeName}.key::date) = {$currentDateData['quarter']}
                            )
                            JOIN jsonb_each_text({$attributeName}.value::jsonb) AS {$innerPreviousDateAttributeName}(key, value) ON (
                                date_part('year', {$innerPreviousDateAttributeName}.key::date) = {$previousDateData['year']}
                                AND date_part('quarter', {$innerPreviousDateAttributeName}.key::date) = {$previousDateData['quarter']}
                            )
                            WHERE period = '{$period}'
                            GROUP BY ticker, period
                        )
                    ");

                    if (isset($formatedCriterion['comparisonValue'])) {
                        $comparisonExpression = $this->getComparisonExpression($formatedCriterion['comparisonValue'], $formatedCriterion['type']);

                        $filterExpression = "
                        CASE
                            WHEN MAX(\"{$firstTmpColumn}\"::numeric) != 0 THEN
                                MAX(\"{$secondTmpColumn}\"::numeric) / MAX(\"{$firstTmpColumn}\"::numeric)
                            ELSE NULL
                         END " . $comparisonExpression;
                    }

                    if (!empty($filterExpression)) {
                        $filters[] = $filterExpression;
                    }

                    if (!empty($comparisonExpression)) {
                        $counters[] = "COUNT(CASE WHEN \"{$columnName}\"::numeric {$comparisonExpression} THEN 1 ELSE NULL END) OVER () AS \"counter_{$criterion['id']}\"";
                    }

                    $calculations[] = "
                        CASE
                            WHEN MAX({$firstTmpColumn}::numeric) != 0  THEN
                                MAX({$secondTmpColumn}::numeric) / MAX({$firstTmpColumn}::numeric)
                            ELSE NULL
                        END AS \"{$columnName}\"
                    ";
                    $joins[] = "LEFT JOIN {$cteTableName} ON p.symbol = {$cteTableName}.ticker";

                    break;
                case 'cagr':
                    $firstTmpColumn = 'tmp_column_' . uniqid();
                    $secondTmpColumn = 'tmp_column_' . uniqid();

                    $currentDateData = $this->getCurrentDate($formatedCriterion['dates'][1]);
                    $previousDateData = $this->getCurrentDate($formatedCriterion['dates'][0]);

                    $cteTableQueries[] = DB::raw("
                        {$cteTableName} AS (
                            SELECT
                                ticker,
                                period,
                                MAX(CASE
                                    WHEN date_part('year', {$innerCurrentDateAttributeName}.key::date) = {$currentDateData['year']} THEN
                                        TRIM(BOTH '\"' FROM split_part(
                                            REPLACE(REPLACE({$innerCurrentDateAttributeName}.value::text, '[\"', ''), '\"]', ''),
                                            '|',
                                            1
                                        ))
                                    ELSE NULL
                                END) AS \"{$firstTmpColumn}\",

                                MAX(CASE
                                    WHEN date_part('year', {$innerPreviousDateAttributeName}.key::date) = {$previousDateData['year']} THEN
                                        TRIM(BOTH '\"' FROM split_part(
                                            REPLACE(REPLACE({$innerPreviousDateAttributeName}.value::text, '[\"', ''), '\"]', ''),
                                            '|',
                                            1
                                        ))
                                    ELSE NULL
                                END) AS \"{$secondTmpColumn}\"

                            FROM public.info_tikr_presentations r
                            JOIN jsonb_each_text(r.{$jsonFieldName}::jsonb) AS $attributeName(key, value) ON {$attributeName}.key ILIKE '%$metricName%'
                            JOIN jsonb_each_text({$attributeName}.value::jsonb) AS {$innerCurrentDateAttributeName}(key, value) ON (
                                date_part('year', {$innerCurrentDateAttributeName}.key::date) = {$currentDateData['year']}
                            )
                            JOIN jsonb_each_text({$attributeName}.value::jsonb) AS {$innerPreviousDateAttributeName}(key, value) ON (
                                date_part('year', {$innerPreviousDateAttributeName}.key::date) = {$previousDateData['year']}
                            )
                            WHERE period = '{$period}'
                            GROUP BY ticker, period
                        )
                    ");

                    $yearsCount = (int)$currentDateData['year'] - (int)$previousDateData['year'];

                    if (isset($formatedCriterion['comparisonValue'])) {
                        $comparisonExpression = $this->getComparisonExpression($formatedCriterion['comparisonValue'], $formatedCriterion['type']);
                        $filterExpression = "
                        CASE
                            WHEN MAX(\"{$firstTmpColumn}\"::numeric) != 0 AND {$yearsCount} !=0 THEN
                                POW(ABS(MAX(\"{$secondTmpColumn}\"::numeric) / MAX(\"{$firstTmpColumn}\"::numeric)), (1.0 / {$yearsCount}))
                            ELSE NULL
                         END " . $comparisonExpression;
                    }

                    if (!empty($filterExpression)) {
                        $filters[] = $filterExpression;
                    }

                    if (!empty($comparisonExpression)) {
                        $counters[] = "COUNT(CASE WHEN \"{$columnName}\"::numeric {$comparisonExpression} THEN 1 ELSE NULL END) OVER () AS \"counter_{$criterion['id']}\"";
                    }

                    $calculations[] = "
                        CASE
                            WHEN MAX(\"{$firstTmpColumn}\"::numeric) != 0 AND {$yearsCount} !=0 THEN
                                POW(ABS(MAX(\"{$secondTmpColumn}\"::numeric) / MAX(\"{$firstTmpColumn}\"::numeric)), (1.0 / {$yearsCount}))
                            ELSE NULL
                         END AS \"{$columnName}\"
                    ";
                    $joins[] = "LEFT JOIN {$cteTableName} ON p.symbol = {$cteTableName}.ticker";

                    break;
            }
        }

        $cteSql =
            'WITH ' .
            implode(', ', $cteTableQueries) . ', ' .
            "results AS (
                SELECT
                    r.ticker,
                    MAX(p.registrant_name) AS registrant_name,
                    p.country,
                    p.sic_group,
                    p.sic_description,
                    p.exchange" .
                    (count($selects) > 0 ? ', ' . implode(', ', $selects) : '') .
                    (count($calculations) > 0 ? ', ' . implode(', ', $calculations) : '') . "
                FROM info_tikr_presentations as r
                LEFT JOIN company_profile as p ON r.ticker = p.symbol
                " . implode(" ", $joins) . "
                " . (strlen($universeCriteriaWeres) > 0 ? "WHERE {$universeCriteriaWeres}" : '') . "
                GROUP BY " . implode(", ", $groupBys) . "
                " . (count($filters) > 0 ? "HAVING " . implode(" OR ", $filters) : '') . "
            )
            SELECT
                *" .
                    (count($counters) > 0 ? ', ' . implode(', ', $counters) : '') . "
            FROM results";
        $results = DB::connection('pgsql-xbrl')->select(DB::raw($cteSql));
        $results = json_decode(json_encode($results), true);

        return $results;
    }

    public function getPresetCriteria($presetType)
    {
        $presetMap = [
            'quality' => [
                [
                    'metric' => 'income_statement||Total Revenues',
                    'type' => 'cagr',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 5)
                ],
                [
                    'metric' => 'ratios||Gross Profit Margin %',
                    'type' => 'value',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 0)
                ],
                [
                    'metric' => 'ratios||EBIT Margin %',
                    'type' => 'value',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 0)
                ],
                [
                    'metric' => 'income_statement||Basic EPS: As Reported',
                    'type' => 'cagr',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 5)
                ],
                [
                    'metric' => 'ratios||Return on Invested Capital % (ROIC)',
                    'type' => 'value',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 0)
                ],
                [
                    'metric' => 'ratios||Return on Assets % (ROA)',
                    'type' => 'value',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 0)
                ],
                [
                    'metric' => 'ratios||Return On Equity % (ROE)',
                    'type' => 'value',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 0)
                ],
            ],
            'growth' => [
                [
                    'metric' => 'income_statement||Total Revenues',
                    'type' => 'growth',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 0)
                ],
                [
                    'metric' => 'income_statement||Basic EPS: As Reported',
                    'type' => 'growth',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 0)
                ],
                [
                    'metric' => 'income_statement||Total Revenues',
                    'type' => 'cagr',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 3)
                ],
                [
                    'metric' => 'income_statement||Basic EPS: As Reported',
                    'type' => 'cagr',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 3)
                ],
                [
                    'metric' => 'income_statement||Basic EPS: As Reported',
                    'type' => 'cagr',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 5)
                ],
            ],
            'risk' => [
                [
                    'metric' => 'ratios||Total Debt / EBITDA',
                    'type' => 'value',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 0)
                ],
                [
                    'metric' => 'ratios||Net Debt / EBITDA',
                    'type' => 'value',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 0)
                ],
                [
                    'metric' => 'ratios||EBIT / Interest Expense',
                    'type' => 'value',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 0)
                ],
                [
                    'metric' => 'ratios||Current Ratio',
                    'type' => 'value',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 0)
                ],
                [
                    'metric' => 'ratios||Quick Ratio',
                    'type' => 'value',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 0)
                ],
                [
                    'metric' => 'ratios||Total Debt / Equity',
                    'type' => 'value',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 0)
                ],
                [
                    'metric' => 'ratios||Total Assets / Total Equity',
                    'type' => 'value',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 0)
                ],
            ],
            'returnRatios' => [
                [
                    'metric' => 'ratios||Return on Assets % (ROA)',
                    'type' => 'value',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 0)
                ],
                [
                    'metric' => 'ratios||Return on Invested Capital % (ROIC)',
                    'type' => 'value',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 0)
                ],
                [
                    'metric' => 'ratios||Return On Equity % (ROE)',
                    'type' => 'value',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 0)
                ],
                [
                    'metric' => 'ratios||Return on Common Equity %',
                    'type' => 'value',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 0)
                ],
                [
                    'metric' => 'ratios||Return on Tangible Capital (ROTC)',
                    'type' => 'value',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 0)
                ],
                [
                    'metric' => 'ratios||Return on Incremental Invested Capital (ROIIC)',
                    'type' => 'value',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 0)
                ],
            ],
            'marginAnalysis' => [
                [
                    'metric' => 'ratios||Gross Profit Margin %',
                    'type' => 'value',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 0)
                ],
                [
                    'metric' => 'ratios||SG&A Margin %',
                    'type' => 'value',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 0)
                ],
                [
                    'metric' => 'ratios||R&D Margin %',
                    'type' => 'value',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 0)
                ],
                [
                    'metric' => 'ratios||EBIT Margin %',
                    'type' => 'value',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 0)
                ],
                [
                    'metric' => 'ratios||EBITDA Margin %',
                    'type' => 'value',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 0)
                ],
                [
                    'metric' => 'ratios||Net Income Margin %',
                    'type' => 'value',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 0)
                ],
                [
                    'metric' => 'ratios||EBITA Margin %',
                    'type' => 'value',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 0)
                ],
                [
                    'metric' => 'ratios||EBT Margin %',
                    'type' => 'value',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 0)
                ],
                [
                    'metric' => 'ratios||Levered Free Cash Flow Margin %',
                    'type' => 'value',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 0)
                ],
                [
                    'metric' => 'ratios||Unlevered Free Cash Flow Margin %',
                    'type' => 'value',
                    'period' => 'annual',
                    'dates' => $this->getPresetDates('annual', 0)
                ],
            ]
        ];

        return $presetMap[$presetType];
    }

    public function getPresetDates($period, $yearCount)
    {
        $financialPeriodEnd = now()->subYear()->year;

        if ($yearCount === 0) {
            return ["FY $financialPeriodEnd"];
        }

        $financialPeriodStart = now()->year($financialPeriodEnd)->subYears($yearCount)->year;

        return ["FY $financialPeriodStart", "FY $financialPeriodEnd"];
    }

    public function getPreviousDate($date): array
    {
        [$quarter, $currentYear] = explode(' ', $date);
        $previousYear = intval($currentYear) - 1;

        if (str_starts_with($date, 'Q')) {
            $previousQuarter = $quarter === 'Q1' ? 'Q4' : 'Q' . (int)substr($quarter, 1) - 1;

            return ['quarter' => $previousQuarter[1], 'year' => $quarter === 'Q1' ? $previousYear : $currentYear];
        }

        return ['quarter' => null, 'year' => $previousYear, 'initialDate' => $date];
    }

    public function getCurrentDate($date): array
    {
        [$quarter, $year] = explode(' ', $date);

        if (str_starts_with($date, 'Q')) {
            return ['quarter' => $quarter[1], 'year' => $year, 'initialDate' => $date ];
        }

        return  ['quarter' => null, 'year' => $year, 'initialDate' => $date ];
    }

    public function getColumnType($data): string|null
    {
        return match ($data) {
            'value' => null,
            'growth'=> '% Growth YoY',
            'cagr' => 'CAGR'
        };
    }

    public function getComparisonExpression($comparisonData, $financialCriteriaType): string
    {
        return match ($comparisonData['type']) {
            'greaterThan' => "> {$comparisonData['data']}",
            'lesserThan' => "< {$comparisonData['data']}",
            'between' => "BETWEEN {$comparisonData['data']['first']} AND {$comparisonData['data']['second']}",
        };
    }

    public function makeUniverseCriteriaFilterString($universeCriteriaData): string
    {
        $result = [];

        foreach ($universeCriteriaData as $key => $value) {

            // Todo
            if ($key === 'marketCap') {
                continue;
            }

            if (count($value['data']) < 1) {
                continue;
            }

            $formatedFilterValues = array_map(fn ($item) => "'{$item}'", $value['data']);
            $formatedFilterValues = implode(', ', $formatedFilterValues);

            $result[] = "{$this->filterFieldsMap[$key]} IN ({$formatedFilterValues})";
        }

        return implode(' AND ', $result);
    }
}
