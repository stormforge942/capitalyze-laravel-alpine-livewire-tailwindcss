<?php

namespace App\Http\Livewire\Builder;

use Livewire\Component;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Models\CompanyChartComparison;
use App\Services\ChartBuilderService;

class Chart extends Component
{
    public ?array $tab = null;
    public array $metricsMap = [];

    protected $listeners = [
        'tabChanged' => 'tabChanged',
        'companiesChanged' => 'companiesChanged',
        'metricsChanged' => 'metricsChanged',
    ];

    public function mount()
    {
        $this->metricsMap = ChartBuilderService::options(true);
    }

    public function render()
    {
        $data = [];

        if ($this->tab) {
            $data = ChartBuilderService::resolveData($this->tab['companies'], $this->tab['metrics']);
        }

        return view('livewire.builder.chart', [
            ...$data
        ]);
    }

    public function tabChanged($tab)
    {
        $this->tab = $tab;

        $this->tab['filters'] = [
            'period' => data_get($this->tab, 'filters.period', 'annual'),
            'dateRange' => data_get($this->tab, 'filters.dateRange', []),
            'unit' => data_get($this->tab, 'filters.unit', 'Millions'),
            'decimalPlaces' => data_get(
                $this->tab,
                'filters.decimalPlaces',
                data_get(Auth::user(), 'settings.decimalPlaces', 1)
            ),
        ];
    }

    public function companiesChanged($companies)
    {
        $this->tab['companies'] = $companies;
        $this->updateTab();
    }

    public function metricsChanged($metrics)
    {
        $this->tab['metrics'] = $metrics;
        $this->updateTab();
    }

    private function updateTab()
    {
        CompanyChartComparison::query()
            ->where('user_id', auth()->id())
            ->where('id', $this->tab['id'])
            ->update(Arr::only($this->tab, ['companies', 'metrics', 'filters', 'config']));
    }
}
