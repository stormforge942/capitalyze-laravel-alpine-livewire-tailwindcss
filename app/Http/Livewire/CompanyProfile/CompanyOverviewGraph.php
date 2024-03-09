<?php

namespace App\Http\Livewire\CompanyProfile;

use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CompanyOverviewGraph extends Component
{
    public $ticker = "";
    public $currentChartPeriod = "3m";
    public $chartData = [];
    public $dateRange = [null, null];

    public $chartPeriods = [
        '3m' => '3 months',
        '6m' => '6 months',
        '1yr' => '1 year',
        'YTD' => 'current year',
        '5yr' => '5 years',
        'max' => 'all time',
        'custom' => 'custom',
    ];

    public $name = '';
    public $percentage = null;

    public function updatedDateRange(array $range)
    {
        if (!$range[0] || !$range[1]) {
            return;
        }

        $this->currentChartPeriod = 'custom';
        $this->dateRange = $range;
        $this->load();
    }

    public function mount($ticker)
    {
        $this->name = Company::find($ticker)->name;
        $this->ticker = $ticker;
        $this->load();
    }

    public function updated($propertyName)
    {
        if ($propertyName == 'currentChartPeriod') {
            if ($this->currentChartPeriod != 'custom') {
                $this->load();
            }
        }
    }

    public function load()
    {
        $this->percentage = 0;
        $this->chartData = [
            'dataset1' => [],
            'dataset2' => [],
        ];

        $period = $this->getPeriod();

        $result = DB::connection('pgsql-xbrl')
            ->table('eod_prices')
            ->select('date', 'adj_close', 'volume')
            ->selectRaw('AVG(adj_close) OVER () as adj_close_avg')
            ->selectRaw('MAX(adj_close) OVER () as max_adj_close')
            ->selectRaw('MIN(adj_close) OVER () as min_adj_close')
            ->selectRaw('AVG(volume) OVER () as volume_avg')
            ->where('symbol', strtolower($this->ticker))
            ->whereBetween('date', $period)
            ->orderBy('date')
            ->get();

        if (!$result->count()) {
            $this->resetChart();
            return;
        }

        if ($result->count() > 1) {
            $first = $result->first()->adj_close;
            $last = $result->last()->adj_close;
            $this->percentage = $last ? round((($last - $first) / $last) * 100, 2) : 0;
        }

        $maxPrice = 0;
        $volume = ['min' => INF, 'max' => 0];
        foreach ($result as $item) {
            $maxPrice = $maxPrice < $item->adj_close ? $item->adj_close : $maxPrice;
            $volume['min'] = $volume['min'] > $item->volume ? $item->volume : $volume['min'];
            $volume['max'] = $volume['max'] < $item->volume ? $item->volume : $volume['max'];
        }

        $result->each(function ($item) use ($maxPrice, $volume) {
            $quote = $item;
            if ($this->currentChartPeriod == '5yr' || $this->currentChartPeriod == 'max') {
                $quote = $quote[0];
            }

            $this->chartData['dataset1'][] = [
                'x' => Carbon::parse($quote->date)->format('Y-m-d'),
                'y' => number_format($quote->adj_close, 4),
            ];

            $min = 0;
            $max = 0.2 * $maxPrice;

            $volume = ($quote->volume - $volume['min']) / ($volume['max'] - $volume['min']) * ($max - $min) + $min;

            $this->chartData['dataset2'][] = [
                'x' => Carbon::parse($quote->date)->format('Y-m-d'),
                'y' => $volume,
                'source' => number_format($quote->volume)
            ];
        });

        $this->chartData['max'] = $maxPrice;
        [$this->chartData['quantity'], $this->chartData['unit']] = $this->calculateDateDifference($this->getPeriod());

        $this->resetChart();
    }

    public function countYPaddingValue($max)
    {
        return ceil($max / 50) * 50;
    }

    public function resetChart()
    {
        $this->emit('companyChartReset', $this->chartData);
    }

    public function getPeriod()
    {
        $toDate = Carbon::now();
        $fromDate = Carbon::now()->subMonths(3);

        switch ($this->currentChartPeriod) {
            case '6m':
                $fromDate = Carbon::now()->subMonths(6);
                return [$fromDate, $toDate];

            case '1yr':
                $fromDate = Carbon::now()->subYear();
                return [$fromDate, $toDate];

            case 'YTD':
                $fromDate = Carbon::now()->startOfYear();
                return [$fromDate, $toDate];

            case '5yr':
                $fromDate = Carbon::now()->subYears(5);
                return [$fromDate, $toDate];

            case 'custom':
                $fromDate = Carbon::parse($this->dateRange[0]);
                $toDate = Carbon::parse($this->dateRange[1]);
                return [$fromDate, $toDate];

            case 'max':
                $fromDate = Carbon::parse(
                    DB::connection('pgsql-xbrl')
                        ->table('eod_prices')->min('date')
                );
                return [$fromDate, $toDate];
        }

        return [$fromDate, $toDate];
    }

    public function calculateDateDifference($period)
    {
        $fromDateTime = Carbon::parse($period[0]);
        $toDateTime = Carbon::parse($period[1]);

        $interval = $fromDateTime->diffInMonths($toDateTime);

        if ($interval < 13) {
            return [$interval + 1, 'month'];
        } else {
            return [$fromDateTime->diffInYears($toDateTime) + 1, 'year'];
        }
    }

    public function render()
    {
        return view('livewire.company-profile.company-overview-graph');
    }
}
