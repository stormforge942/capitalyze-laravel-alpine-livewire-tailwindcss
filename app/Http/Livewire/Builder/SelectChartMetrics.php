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
                    'items' => [
                        'Revenue',
                        'Other Revenues',
                        'Financial Div. Revenues',
                        'Gain (Loss) on Sale of Asset',
                        'Gain (Loss) on Sale of Investment (Total)',
                        'Interest and Investment Income',
                    ]
                ],
                [
                    'title' => 'Income Statement',
                    'has_children' => true,
                    'items' => [
                        'Revenue' => [
                            'Total Revenue',
                            'Cost of Goods Sold',
                            'Total Gross Profit',
                        ],
                        'Income' => [
                            'Total Operating Income',
                            'Interest & Investment Income',
                            'Other Non Operating Income (Expenses)',
                            'Earnings From Continuing Operations',
                            'Net Income to Company',
                            'Net Income to Common',
                            'Earnings Before Taxes (EBT)',
                        ],
                        'Expenses' => [
                            'SG&A Expenses',
                            'R&D Expenses',
                            'Total Operating Expenses',
                            'Interest Expense',
                            'Income Tax Expense',
                        ],
                    ]
                ],
            ]
        ]);
    }
}
