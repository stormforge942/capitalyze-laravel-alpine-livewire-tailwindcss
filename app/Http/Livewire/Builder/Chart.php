<?php

namespace App\Http\Livewire\Builder;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\CompanyChartComparison;
use App\Services\ChartBuilderService;
use Illuminate\Support\Arr;

class Chart extends Component
{
    public ?array $tab = null;
    public string $panel = 'single-panel';
    public array $companies = [];
    public array $metrics = [];
    public ?array $filters = null;
    public array $metricAttributes = [];
    public array $metricsColor;
    public bool $showLabel = true;

    protected $listeners = [
        'tabChanged' => 'tabChanged',
        'companiesChanged' => 'companiesChanged',
        'metricsChanged' => 'metricsChanged',
    ];

    public function mount()
    {
        $this->resetColors();
    }

    public function render()
    {
        return view('livewire.builder.chart', [
            ...$this->getData(),
            'metricsMap' => ChartBuilderService::options(true),
        ]);
    }

    private function getData()
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

        return $data;
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

        $this->panel = $_tab['panel'] ?? 'single-panel';

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

        $this->showLabel = true;
    }

    private function resetColors()
    {
        $this->metricsColor = [
            'sp' => ['a' => 'test'],
            'ms' => ['a' => 'test'],
            'mm' => ['a' => 'test'],
        ];
    }

    public function companiesChanged($companies)
    {
        $this->companies = $companies;
        $this->updateTab();
    }

    public function metricsChanged($metrics)
    {
        $this->metrics = $metrics;
        $this->metricAttributes = Arr::only($this->metricAttributes, $metrics);

        $this->updateTab();
    }

    public function panelChanged($panel)
    {
        $this->panel = $panel;
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
