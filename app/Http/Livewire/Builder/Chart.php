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
    public array $companies = [];
    public array $metrics = [];
    public ?array $filters = null;
    public array $metricAttributes = [];

    protected $listeners = [
        'tabChanged' => 'tabChanged',
        'companiesChanged' => 'companiesChanged',
        'metricsChanged' => 'metricsChanged',
    ];

    public function mount()
    {
    }

    public function render()
    {
        $data = [
            'data' => [
                'annual' => [],
                'quarter' => [],
            ],
            'dates' => [
                'annual' => [],
                'quarter' => [],
            ],
            'dateRange' => [
                'annual' => [2000, 0 + date('Y')],
                'quarter' => [2000, 0 + date('Y')],
            ],
        ];

        if ($this->tab) {
            $data = ChartBuilderService::resolveData(
                $this->companies,
                $this->metrics,
                $this->metricAttributes,
            ) ?? $data;
        }

        return view('livewire.builder.chart', [
            ...$data,
            'metricsMap' => ChartBuilderService::options(true),
        ]);
    }

    public function tabChanged($tab)
    {
        $this->tab = $tab;

        $_tab = CompanyChartComparison::query()
            ->where('user_id', auth()->id())
            ->where('id', $tab['id'])
            ->select('companies', 'metrics', 'filters', 'metric_attributes', 'panel')
            ->first();

        $this->companies = $_tab['companies'];
        $this->metrics = $_tab['metrics'];

        $this->filters = [
            'period' => data_get($_tab, 'filters.period', 'annual'),
            'dateRange' => data_get($_tab, 'filters.dateRange', []),
            'unit' => data_get($_tab, 'filters.unit', 'Millions'),
            'decimalPlaces' => data_get(
                $_tab,
                'filters.decimalPlaces',
                data_get(Auth::user(), 'settings.decimalPlaces', 1)
            ),
        ];

        if (!count($this->filters['dateRange'])) {
            $this->filters['dateRange'] = [
                date('Y') - 2,
                0 + date('Y'),
            ];
        }

        $this->metricAttributes = $_tab['metric_attributes'];
    }

    public function companiesChanged($companies)
    {
        $this->companies = $companies;
        $this->updateTab();
    }

    public function metricsChanged($metrics)
    {
        $this->metrics = $metrics;
        $this->updateTab();
    }

    private function updateTab()
    {
        CompanyChartComparison::query()
            ->where('user_id', auth()->id())
            ->where('id', $this->tab['id'])
            ->update([
                'companies' => $this->companies,
                'metrics' => $this->metrics,
            ]);
    }
}
