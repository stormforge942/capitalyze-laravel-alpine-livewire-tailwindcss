<?php

namespace App\Http\Livewire\Ownership;

use Illuminate\Support\Facades\DB;
use WireElements\Pro\Components\Modal\Modal;

class MutualFundHistory extends Modal
{
    public array $company;
    public array $fund;
    public bool $loading = true;
    public array $chartData = [];

    public function mount()
    {
        $this->loading = true;
    }

    public function render()
    {
        return view('livewire.ownership.mutual-fund-history');
    }

    public static function attributes(): array
    {
        return [
            'size' => '6xl',
        ];
    }

    public function load()
    {
        $data = DB::connection('pgsql-xbrl')
            ->table('mutual_fund_holdings')
            ->where($this->fund)
            ->whereNotNull(['balance', 'estimated_average_price'])
            ->where('symbol', $this->company['symbol'])
            ->orderBy('period_of_report', 'asc')
            ->get([
                "period_of_report",
                "balance",
                "estimated_average_price",
            ]);

        $this->chartData = [
            'labels' => $data->pluck('period_of_report')->toArray(),
            'datasets' => [
                [
                    'label' => 'Average Price Paid',
                    'type' => 'line',
                    'fill' => false,
                    'data' => $data->pluck('estimated_average_price')->toArray(),
                    'borderColor' => '#C22929',
                    'yAxisID' => 'y1',
                    'pointHoverBackgroundColor' => '#ffff',
                ],
                [
                    'label' => 'Shares Held',
                    'data' => $data->pluck('balance')->toArray(),
                    'backgroundColor' => '#52D3A2',
                    'hoverBackgroundColor' => '#13B05B',
                    'borderColor' => '#52D3A2',
                    'borderRadius' => 4,
                ],
            ]
        ];

        $this->loading = false;
    }
}
