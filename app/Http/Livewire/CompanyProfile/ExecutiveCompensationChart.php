<?php

namespace App\Http\Livewire\CompanyProfile;

use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\ExecutiveCompensation;
use App\Models\InfoTikrPresentation;

class ExecutiveCompensationChart extends Component
{
    public $symbol;
    public $chartData;
    public $year;
    public $totalRevenue;

    public function mount($symbol, $year)
    {
        $this->symbol = $symbol;
        $this->year = $year;
        $this->totalRevenue = $this->getTotalRevenue();
        $this->chartData = $this->getChartData();
    }

    protected $listeners = ['updateExecutiveCompensationTable' => 'updateProps'];

    private function getTotalRevenue()
    {   
        $data = DB::connection('pgsql-xbrl')
            ->table('info_tikr_presentations')
            ->select('income_statement')
            ->where('ticker', $this->symbol)
            ->where("period", 'annual')
            ->first();

        if (! $data) return 0;

        $incomeStatement = $data->income_statement;

        $totalRevenues = $this->formatIncomeData(json_decode($incomeStatement, true))['Total Revenues'];

        foreach ($totalRevenues as $key => $value) {
            if (Carbon::parse($key)->year == $this->year) {
                $totalRevenue = $value;
            }
        }

        return $totalRevenue ?? 0;
    }

    public function updateProps($search, $year)
    {
        $this->year = $year;
        $this->totalRevenue = $this->getTotalRevenue();
        $this->chartData = $this->getChartData();
    }

    private function getChartData()
    {
        $data = ExecutiveCompensation::query()
            ->when($this->symbol, fn ($q) => $q->where('symbol', $this->symbol))
            ->when($this->year, fn ($q) => $q->where('year', $this->year))
            ->orderByDesc('filing_date')
            ->get()
            ->map(function ($item) {
                $item->normalized_name_and_position = strtolower(preg_replace('/\s+/', '', $item->name_and_position));
                return $item;
            })
            ->unique('normalized_name_and_position')
            ->values()
            ->sort(function ($a, $b) {
                return $b->total - $a->total;
            })
            ->toArray();

        $chartData = [];
        foreach ($data as $item) {
            
            if ($this->totalRevenue) $res = $item['total'] / $this->totalRevenue * 100;
            else $res = $item['total'];

            $chartData[$item['name_and_position']] = $res;
        }

        return $chartData;
    }

    private function formatIncomeData($data)
    {
        $result = [];

        foreach ($data as $key => $value) {
            $key = explode("|", $key)[0];

            if ($key === 'Total Revenues') {
                $result[$key] = $this->formatValue($value);
            }
        }

        return $result;
    }

    private function formatValue($value)
    {
        return array_map(fn ($val) => intval(explode("|", $val[0] ?? "")[0]), $value);
    }

    public function render()
    {
        return view('livewire.company-profile.executive-compensation-chart');
    }
}
