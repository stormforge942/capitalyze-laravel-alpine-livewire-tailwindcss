<?php

namespace App\Http\Livewire\Builder;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\InfoTikrPresentation;
use Illuminate\Support\Facades\Auth;
use App\Models\CompanyChartComparison;

class Chart extends Component
{
    public array $tabs = [];
    public int $activeTab = 0;
    private $availablePeriods = [
        'quarter',
        'annual'
    ];

    public function mount()
    {
        $tabs = CompanyChartComparison::query()
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'asc')
            ->get();

        if ($tabs->isEmpty()) {
            $tabs->push(CompanyChartComparison::query()->create([
                'name' => 'Untitled Chart',
                'companies' => [],
                'metrics' => [],
                'user_id' => Auth::id()
            ]));
        }

        $this->activeTab = $tabs->last()->id;
        $this->tabs = $tabs->toArray();
    }

    public function render()
    {
        $metrics = [
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
                        'type' => 'line',
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
                        'type' => 'line',
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

        return view('livewire.builder.chart', [
            'data' => $this->getData(),
            'metrics' => $metrics,
            'flattenedMetrics' => $this->flattenMetrics($metrics),
        ]);
    }

    public function deleteTab($id)
    {
        CompanyChartComparison::query()
            ->where('id', $id)
            ->delete();

        $this->mount();
    }

    public function clearAll()
    {
        CompanyChartComparison::query()
            ->where('user_id', Auth::id())
            ->delete();

        $this->mount();
    }

    public function updateTab($id, $name)
    {
        CompanyChartComparison::query()
            ->where('id', $id)
            ->update(['name' => $name]);

        $this->mount();
    }

    public function addTab()
    {
        CompanyChartComparison::query()->create([
            'name' => 'Untitled Chart',
            'companies' => [],
            'metrics' => [],
            'user_id' => Auth::id()
        ]);

        $this->mount();
    }

    public function getData()
    {
        $companies = ['AAPL', 'MSFT'];

        $metrics = [
            'income_statement||Total Revenues',
            'income_statement||Total Operating Income',
            'income_statement||Total Operating Expenses',
            'balance_sheet||Cash And Equivalents',
            'balance_sheet||Total Receivables',
            'balance_sheet||Total Current Assets',
        ];

        $data = array_reduce($this->availablePeriods, function ($c, $i) use ($companies) {
            $c[$i] = array_reduce($companies, function ($d, $j) {
                $d[$j] = [];
                return $d;
            }, []);
            return $c;
        }, []);

        $this->fillStandarisedData($companies, $data, $metrics);

        return [
            'data' => $data,
            'dates' => $this->extractDates($data),
        ];
    }

    private function fillStandarisedData($companies, array &$data, array $metrics): void
    {
        $standardKeys = [];
        foreach ($metrics as $metric) {
            if (!Str::startsWith($metric, ['income_statement||', 'balance_sheet||'])) {
                continue;
            }

            [$column, $key] = explode('||', $metric, 2);

            if (!isset($standardKeys[$column])) {
                $standardKeys[$column] = [];
            }

            $standardKeys[$column][] = $key;
        }

        if (empty($standardKeys)) {
            return;
        }

        $standardData = InfoTikrPresentation::query()
            ->whereIn('ticker', $companies)
            ->select(['ticker', 'period', ...array_keys($standardKeys)])
            ->get()
            ->groupBy('period');

        foreach ($standardData as $period => $items) {
            if (!in_array($period, $this->availablePeriods)) {
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

                        $data[$period][$item->ticker][$column . '||' . $key] = $value;
                    }
                }
            }
        }
    }

    private function extractDates(array $data): array
    {
        $dates = array_reduce($this->availablePeriods, function ($c, $i) {
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

    private function flattenMetrics($metrics)
    {
        $flattened = [];

        foreach ($metrics as $metric) {
            if ($metric['has_children']) {
                $items = $metric['items'];
            } else {
                $items = [
                    'Dummy' => $metric['items']
                ];
            }

            foreach ($items as $item) {
                $flattened = array_merge($flattened, $item);
            }
        }

        return $flattened;
    }
}
