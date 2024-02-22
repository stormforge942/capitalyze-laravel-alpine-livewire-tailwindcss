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
                    'title' => 'Balance Sheet',
                    'has_children' => true,
                    'items' => [
                        'Assets' => [
                            'Cash and Equivalents',
                            'Short Term Investments',
                            'Trading Assets Securities, Total',
                            'Total Cash and Short Term Investments',
                            'Accounts Receivable, Total',
                            'Other Receiveable',
                        ],
                    ]
                ]
            ]
        ]);
    }
}
