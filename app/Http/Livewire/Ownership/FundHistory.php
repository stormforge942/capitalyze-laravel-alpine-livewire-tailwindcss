<?php

namespace App\Http\Livewire\Ownership;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use WireElements\Pro\Components\Modal\Modal;

class FundHistory extends Modal
{
    public array $company = [];
    public string $fund = '';
    public array $dateRange = [null, null];
    public bool $loading = true;
    public array $chartData = [];

    public function mount()
    {
        $this->loading = true;
    }

    public function render()
    {
        return view('livewire.ownership.fund-history', [
            'chartPeriods' => [
                '3m' => '3 months',
                '6m' => '6 months',
                '1yr' => '1 year',
                'YTD' => 'current year',
                '5yr' => '5 years',
                'max' => 'all time',
                'custom' => 'custom',
            ],
        ]);
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
            ->table('filings')
            ->where('cik', $this->fund)
            ->whereNotNull(['ssh_prnamt', 'estimated_average_price'])
            ->where('symbol', $this->company['symbol'])
            ->orderBy('report_calendar_or_quarter', 'asc')
            ->get([
                "report_calendar_or_quarter",
                "ssh_prnamt",
                "estimated_average_price",
            ]);

        $this->chartData = [
            'labels' => $data->pluck('report_calendar_or_quarter')
                ->map(fn ($item) => Carbon::parse($item)->format('Y M'))
                ->toArray(),
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
                    'label' => 'Common Stock Equivalent Held',
                    'data' => $data->pluck('ssh_prnamt')->toArray(),
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
