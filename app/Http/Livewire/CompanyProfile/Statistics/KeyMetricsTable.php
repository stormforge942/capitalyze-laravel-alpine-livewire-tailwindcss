<?php

namespace App\Http\Livewire\CompanyProfile\Statistics;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class KeyMetricsTable extends Component
{
    public $symbol;
    public $company_name;
    private $data;

    public function mount($symbol, $company_name)
    {
        $this->symbol = $symbol;
        $this->company_name = $company_name;

        $this->getKeyMetrics();
    }

    public function getKeyMetrics()
    {
        $data = DB::connection('pgsql-xbrl')
            ->table('key_metrics')
            ->when($this->symbol, fn ($q) => $q->where('symbol', $this->symbol))
            ->orderBy('period_of_report', 'desc')
            ->get();

        // data->metrics is json but stored as string
        foreach ($data as $key => $value) {
            $data[$key]->metrics = json_decode($value->metrics);
        }

        $this->data = $data;
    }

    public function render()
    {
        return view('livewire.company-profile.statistics.key-metrics-table', [
            'data' => $this->data,
        ]);
    }
}
