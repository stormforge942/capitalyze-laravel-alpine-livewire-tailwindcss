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
    public $start_at = null;
    public $end_at = null;

    protected $listeners = ['dateRangeSelected'];

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
    public $persentage = null;

    public function dateRangeSelected($start_at, $end_at)
    {
        $this->currentChartPeriod = 'custom';
        $this->start_at = $start_at;
        $this->end_at = $end_at;
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
        $this->chartData = [
            'label' => [],
            'dataset1' => [],
            'dataset2' => [],
        ];


        $result = DB::connection('pgsql-xbrl')
            ->table('eod_prices')
            ->select('date', 'adj_close', 'volume')
            ->selectRaw('AVG(adj_close) OVER () as adj_close_avg')
            ->selectRaw('MAX(adj_close) OVER () as max_adj_close')
            ->selectRaw('MIN(adj_close) OVER () as min_adj_close')
            ->selectRaw('AVG(volume) OVER () as volume_avg')
            ->where('symbol', strtolower($this->ticker))
            ->whereBetween('date', $this->getPeriod())
            ->orderBy('date')
            ->get();

        $adj_close_avg = round($result->first()->adj_close_avg);
        $max = round($result->first()->max_adj_close);
        $min = round($result->first()->min_adj_close);
        $volume_avg = round($result->first()->volume_avg);

        foreach ($result as $row) {
            unset($row->adj_close_avg, $row->max_adj_close, $row->min_adj_close, $row->volume_avg);
        }

        $divider = 1;

        if (count($result) > 1) {
            $first = $result->first()->adj_close;
            $last = $result->last()->adj_close;
            $this->persentage
                = round((($last - $first) / $last) * 100, 2);
        }

        if (!$volume_avg || !$adj_close_avg) {
            $this->resetChart();
            return;
        }

        while (strlen((string)$volume_avg) >= strlen((string)$adj_close_avg))
        {
            $volume_avg /= 5;
            $volume_avg = round($volume_avg);
            $divider *= 5;
        }

        while (round($volume_avg) * 10 >= round($adj_close_avg))
        {
            $volume_avg /= 2;
            $volume_avg = round($volume_avg);
            $divider *= 2;
        }

        while (round($volume_avg) * 10 <= round($adj_close_avg))
        {
            $volume_avg *= 2;
            $volume_avg = round($volume_avg);
            $divider /= 2;
        }

        if ($this->currentChartPeriod == '5yr') {
            $result = $result->groupBy(function ($item) {
                return Carbon::parse($item->date)->format('Y-W');
            });
        }

        if ($this->currentChartPeriod == 'max') {
            $result = $result->groupBy(function ($item) {
                return Carbon::parse($item->date)->format('Y-m');
            });
        }


        $y_axes_min = $min * 0.95;



        $result->each(function ($item) use ($divider, $y_axes_min, $volume_avg) {
            $quote = $item;
            if ($this->currentChartPeriod == '5yr' || $this->currentChartPeriod == 'max') {
                $quote = $quote[0];
            }

            $this->chartData['dataset1'][] = [
                'x' => Carbon::parse($quote->date)->format('Y-m-d'),
                'y' => number_format($quote->adj_close, 4),
            ];

            $this->chartData['dataset2'][] = [
                'x' => Carbon::parse($quote->date)->format('Y-m-d'),
                'y' => (($quote->volume / $divider) * 3 ) / $volume_avg + $y_axes_min,
                'source' => number_format($quote->volume)
            ];
        });

        [$this->chartData['quantity'], $this->chartData['unit']] = $this->calculateDateDifference($this->getPeriod());
        $this->chartData['divider'] = $divider;
        $this->chartData['y_axes_max'] = $this->countYPaddingValue($max);
        $this->chartData['y_axes_min'] = $y_axes_min;

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
                $fromDate = Carbon::parse($this->start_at);
                $toDate = Carbon::parse($this->end_at);
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

    public function calculateDateDifference($period) {
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
