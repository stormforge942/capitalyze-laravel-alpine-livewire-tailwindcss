<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use App\Models\InfoTikrPresentation;

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

    public static function resolveData($companies, $metrics, $metricAttributes = [])
    {
        $metricsMap = self::options(true);
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
            return [
                'data' => $data,
                'dates' => [],
            ];
        }

        $standardData = InfoTikrPresentation::query()
            ->whereIn('ticker', $companies)
            ->select(['ticker', 'period', ...array_keys($standardKeys)])
            ->get()
            ->groupBy('period');

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

                        if (!isset($metricAttributes[$key])) {
                            $metricAttributes[$key] = [
                                'type' => $metricsMap[$key]['type'] ?? 'bar',
                                'show' => true,
                            ];
                        }

                        $data[$period][$item->ticker][$key] = self::normalizeValue($value, $period);
                    }
                }
            }
        }

        return [
            'data' => $data,
            'dates' => self::extractDates($data),
            'metricAttributes' => $metricAttributes,
        ];
    }

    private static function normalizeValue(array $value, string $period): array
    {
        $val = [];

        foreach ($value as $date => $v) {
            if ($period === 'quarter') {
                $date = Carbon::parse($date)->startOfQuarter();
            } else {
                $date = Carbon::parse($date)->startOfYear();
            }

            $val[$date->toDateString()] = $v;
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
