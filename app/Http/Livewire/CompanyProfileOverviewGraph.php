<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CompanyProfileOverviewGraph extends Component
{
    public $ticker = "";
    public $currentChartPeriod = "3m";
    public $chartData = [];
    public $visible = true;

    public function mount($ticker)
    {
        $this->ticker = $ticker;
        $this->load();
    }

    public function updated($propertyName)
    {
        if ($propertyName == 'currentChartPeriod') {
            $this->load();
        }
    }

    public function toggleVisible()
    {
        $this->visible = !$this->visible;
        if ($this->visible) {
            $this->load();
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
            ->where('symbol', strtolower($this->ticker))
            ->whereBetween('date', $this->getPeriod())
            ->orderBy('date')
            ->get();

        $adj_close_avg = round(DB::connection('pgsql-xbrl')
            ->table('eod_prices')
            ->where('symbol', strtolower($this->ticker))
            ->whereBetween('date', $this->getPeriod())
            ->avg('adj_close'));

        $max = round(DB::connection('pgsql-xbrl')
            ->table('eod_prices')
            ->where('symbol', strtolower($this->ticker))
            ->whereBetween('date', $this->getPeriod())
            ->max('adj_close'));


        $volume_avg = round(DB::connection('pgsql-xbrl')
            ->table('eod_prices')
            ->where('symbol', strtolower($this->ticker))
            ->whereBetween('date', $this->getPeriod())
            ->avg('volume'));

        $divider = 1;

        while (strlen((string)$volume_avg) >= strlen((string)$adj_close_avg))
        {
            $volume_avg /= 10;
            $volume_avg = round($volume_avg);
            $divider *= 10;
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




        $result->each(function ($item) use ($divider) {
            $quote = $item;
            if ($this->currentChartPeriod == '5yr' || $this->currentChartPeriod == 'max') {
                $quote = $quote[0];
            }

            $this->chartData['dataset1'][] = [
                'x' => Carbon::parse($quote->date)->format('Y-m-d'),
                'y' => $quote->adj_close,
            ];

            $this->chartData['dataset2'][] = [
                'x' => Carbon::parse($quote->date)->format('Y-m-d'),
                'y' => number_format($quote->volume / $divider),
                'source' => number_format($quote->volume)
            ];
        });

        [$this->chartData['quantity'], $this->chartData['unit']] = $this->calculateDateDifference($this->getPeriod());
        $this->chartData['divider'] = $divider;
        $this->chartData['y_axes_max'] = $this->countYPaddingValue($max);

        $this->resetChart();
    }

    public function countYPaddingValue($max)
    {
        $height = ceil($max / 100) * 100;
        if ($height - $max < 50) {
            $height += 100;
        }

        return $height;
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
        return view('livewire.company-profile-overview-graph');
    }
}
