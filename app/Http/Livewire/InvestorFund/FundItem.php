<?php

namespace App\Http\Livewire\InvestorFund;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FundItem extends Component
{
    public $fund;
    public $chartData;

    public function mount($fund)
    {
        $this->fund = $fund;

        // Check if the fund is a mutual fund or not
        if (array_key_exists('fund_symbol', $this->fund)) {
            $this->getMutualFundMarketValue();
        } else {
            $this->getFundMarketValue();
        }
    }

    public function getFundMarketValue()
    {
        $data = DB::connection('pgsql-xbrl')
            ->table('filings')
            ->where('cik', $this->fund['cik'])
            ->whereNotNull(['ssh_prnamt', 'estimated_average_price'])
            ->where('symbol', $this->fund['ticker'])
            ->orderBy('report_calendar_or_quarter', 'asc')
            ->get([
                "report_calendar_or_quarter",
                "ssh_prnamt",
                "estimated_average_price",
            ]);

        $this->chartData = [
            'labels' => $data->pluck('report_calendar_or_quarter')
                ->map(fn($item) => Carbon::parse($item)->format('Y M'))
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
                    'borderColor' => '#52D3A2',
                    'borderRadius' => 4,
                    'maxBarThickness' => 150,
                ],
            ],
        ];

        $this->loading = false;
    }

    public function getMutualFundMarketValue()
    {
        $data = DB::connection('pgsql-xbrl')
            ->table('mutual_fund_holdings')
            ->where([
                'fund_symbol' => $this->fund['fund_symbol'],
                'cik' => $this->fund['cik'],
                'series_id' => $this->fund['series_id'],
                'class_id' => $this->fund['class_id'],
                'class_name' => $this->fund['class_name'],
            ])
            ->whereNotNull(['balance', 'estimated_average_price'])
            ->where('symbol', $this->fund['ticker'])
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
            ],
        ];

        $this->loading = false;
    }

    public function render()
    {
        return view('livewire.investor-fund.fund-item');
    }
}
