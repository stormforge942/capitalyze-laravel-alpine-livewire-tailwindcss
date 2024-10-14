<?php

namespace App\Http\Livewire\Builder;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\CompanyChartComparison;
use App\Services\ChartBuilderService;
use Illuminate\Support\Arr;
use stdClass;

class Chart extends Component
{
    public ?array $tab = null;
    public string $panel = 'single-panel';
    public array $companies = [];
    public array $metrics = [];
    public ?array $filters = null;
    public array $metricAttributes = [];
    public array $metricsColor = [];
    public bool $showLabel = false;

    protected $listeners = [
        'tabChanged' => 'tabChanged',
        'companiesChanged' => 'companiesChanged',
        'metricsChanged' => 'metricsChanged',
    ];

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
                'annual' => [2000, intval(date('Y'))],
                'quarter' => [2000, intval(date('Y'))],
            ],
        ];

        if ($this->tab) {
            $_data = ChartBuilderService::resolveData(
                $this->companies,
                $this->metrics,
                $this->metricAttributes,
            );

            $data = $_data ?? $data;

            if ($_data && !count($this->filters['dateRange'])) {
                $range = $data['dateRange'][$this->filters['period']];

                if (!isset($range)) {
                    return $data;
                }

                $start = max($range[0], $range[1] - 10);

                $this->filters['dateRange'] = [$start, $range[1]];
            }
        }


        return $data;
    }

    public function tabChanged($tab)
    {
        $this->tab = $tab;

        $_tab = CompanyChartComparison::query()
            ->where('user_id', auth()->id())
            ->where('id', $tab['id'])
            ->select('companies', 'metrics', 'filters', 'metric_attributes', 'panel', 'metrics_color')
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

        $this->metricAttributes = $_tab['metric_attributes'];

        $this->metricsColor = $_tab['metrics_color'] ?? ['default' => null];

        $this->showLabel = false;
    }

    public function companiesChanged($companies)
    {
        $this->companies = $companies;

        if (!count($companies)) {
            $this->metricAttributes = [];
            $this->filters['dateRange'] = [];
        }

        $this->updateTab();
    }

    public function metricsChanged($metrics)
    {
        $this->metrics = $metrics;
        $this->metricAttributes = Arr::only($this->metricAttributes, $metrics);

        if (!count($metrics)) {
            $this->filters['dateRange'] = [];
        }

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
