<?php

namespace App\Http\Livewire\InvestorFund;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class FundItem extends Component
{
    public $fund;
    public $chartData;
    public $percentage = -10.0;
    public $priceChange = -30.0;

    public function mount($fund)
    {
        $this->fund = $fund;

        // Check if the fund is a mutual fund or not
        if (array_key_exists('fund_symbol', $this->fund) && $this->fund['fund_symbol']) {
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

        $minDate = $data->min('report_calendar_or_quarter');
        $maxDate = $data->max('report_calendar_or_quarter');
        $period = [$minDate, $maxDate];

        $eod_prices = DB::connection('pgsql-xbrl')
            ->table('eod_prices')
            ->select('date', 'adj_close as close')
            ->where('symbol', strtolower($this->fund['ticker']))
            ->whereBetween('date', $period)
            ->get()
            ->keyBy('date')
            ->groupBy(function ($item) {
                $date = Carbon::parse($item->date);
                return $date->endOfQuarter()->format('Y-m-d');
            })
            ->map(function ($group) {
                return $group->last()->close;
            });

        $eod_prices = $data->pluck('report_calendar_or_quarter')
            ->map(function ($item) use ($eod_prices) {
                return $eod_prices->get($item) ?? null;
            });

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
                    'label' => 'Price',
                    'type' => 'line',
                    'fill' => false,
                    'yAxisID' => 'y1',
                    'data' => $eod_prices->values()->toArray(),
                    'borderColor' => '#0000FF',
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

        $minDate = $data->min('period_of_report');
        $maxDate = $data->max('period_of_report');
        $period = [$minDate, $maxDate];

        $eod_prices = DB::connection('pgsql-xbrl')
            ->table('eod_prices')
            ->select('date', 'close')
            ->where('symbol', strtolower($this->fund['ticker']))
            ->whereBetween('date', $period)
            ->get()
            ->keyBy('date')
            ->groupBy(function ($item) {
                $date = Carbon::parse($item->date);
                return $date->endOfQuarter()->format('Y-m-d');
            })
            ->map(function ($group) {
                return $group->last()->close;
            });

        $eod_prices = $data->pluck('period_of_report')
            ->map(function ($item) use ($eod_prices) {
                return $eod_prices->get($item) ?? null;
            });

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
                    'label' => 'Price',
                    'type' => 'line',
                    'fill' => false,
                    'data' => $eod_prices->values()->toArray(),
                    'yAxisID' => 'y1',
                    'borderColor' => '#0000FF',
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
