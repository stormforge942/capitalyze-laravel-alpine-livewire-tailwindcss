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

        $result->each(function ($item) use ($divider) {
            $this->chartData['label'][] = Carbon::parse($item->date)->format('m/d/Y');
            $this->chartData['dataset1'][] = $item->adj_close;
            $this->chartData['dataset2'][] = $item->volume / $divider;
            $this->chartData['divider'] = $divider;
        });

        $this->resetChart();
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
                $fromDate = Carbon::now()->subYears(1);
                return [$fromDate, $toDate];

            case '5yr':
                $fromDate = Carbon::now()->subYears(5);
                return [$fromDate, $toDate];
        }

        return [$fromDate, $toDate];
    }

    public function render()
    {
        return view('livewire.company-profile-overview-graph');
    }
}
