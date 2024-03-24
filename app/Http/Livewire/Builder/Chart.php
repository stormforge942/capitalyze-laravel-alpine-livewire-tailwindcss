<?php

namespace App\Http\Livewire\Builder;

use Livewire\Component;
use App\Models\InfoTikrPresentation;
use Illuminate\Support\Facades\Auth;
use App\Models\CompanyChartComparison;
use Illuminate\Support\Carbon;

class Chart extends Component
{
    public array $tabs = [];
    public array $metricAttributes = [];
    public array $selectedCompanies = [];
    public array $selectedMetrics = [];
    public ?array $filters = null;
    public int $activeTab = 0;
    private $availablePeriods = [
        'quarter',
        'annual'
    ];

    protected $listeners = [
        'updateMetricChartType' => 'updateMetricChartType',
        'toggleMetricVisibility' => 'toggleMetricVisibility',
    ];

    public function mount()
    {
        $tabs = CompanyChartComparison::query()
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'asc')
            ->get();

        if ($tabs->isEmpty()) {
            $tabs->push(CompanyChartComparison::query()->create([
                'name' => 'Untitled Chart',
                'companies' => [],
                'metrics' => [],
                'filters' => [
                    'unit' => 'Millions',
                    'period' => 'quarter',
                ],
                'user_id' => Auth::id(),
            ]));
        }

        if (!$this->activeTab) {
            $activeTab = session('builder.chart.activeTab', $tabs->last()->id);

            if ($tabs->where('id', $activeTab)->isEmpty()) {
                $activeTab = $tabs->last()->id;
            }

            $this->activeTab = $activeTab;
        }
        $this->tabs = $tabs->toArray();

        $this->activeTabChanged();
    }

    public function updated($name)
    {
        if (in_array($name, ['selectedCompanies', 'selectedMetrics', 'filters'])) {
            CompanyChartComparison::query()
                ->where('user_id', Auth::id())
                ->where('id', $this->activeTab)
                ->update([
                    'companies' => $this->selectedCompanies,
                    'metrics' => $this->selectedMetrics,
                    'filters' => $this->filters,
                ]);
        }

        if ($name === 'activeTab') {
            session(['builder.chart.activeTab' => $this->activeTab]);
            $this->activeTabChanged();
        }
    }

    public function changeTab($id)
    {
        $this->activeTab = $id;
    }

    private function activeTabChanged()
    {
        $tab = collect($this->tabs)->firstWhere('id', $this->activeTab);

        if (!$tab) {
            return;
        }

        $this->selectedCompanies = $tab['companies'];
        $this->selectedMetrics = $tab['metrics'];

        $this->filters = $tab['filters'];
    }

    public function updateFilters($filters)
    {
        CompanyChartComparison::query()
            ->where('user_id', Auth::id())
            ->where('id', $this->activeTab)
            ->update(['filters' => $filters]);
    }

    public function render()
    {
        $metrics = config('capitalyze.chart-builder-metrics');

        $flattened = $this->flattenMetrics($metrics);

        return view('livewire.builder.chart', [
            'data' => $this->getData($flattened),
            'metrics' => $metrics,
            'flattenedMetrics' => $flattened,
        ]);
    }

    public function deleteTab($id)
    {
        CompanyChartComparison::query()
            ->where('id', $id)
            ->delete();

        if ($this->activeTab == $id) {
            $this->activeTab = 0;
        }

        $this->mount();
    }

    public function clearAll()
    {
        CompanyChartComparison::query()
            ->where('user_id', Auth::id())
            ->delete();

        $this->mount();
    }

    public function updateTab($id, $name)
    {
        CompanyChartComparison::query()
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->update(['name' => $name]);

        $this->mount();
    }

    public function addTab()
    {
        $tab = CompanyChartComparison::query()->create([
            'name' => 'Untitled Chart',
            'companies' => [],
            'metrics' => [],
            'filters' => [
                'unit' => 'Millions',
                'period' => 'quarter',
            ],
            'user_id' => Auth::id()
        ]);

        $this->activeTab = $tab->id;

        $this->mount();
    }

    public function updateMetricChartType($data)
    {
        $this->metricAttributes[$data['metric']]['type'] = $data['type'];
    }

    public function toggleMetricVisibility($metric)
    {
        $this->metricAttributes[$metric]['show'] = !$this->metricAttributes[$metric]['show'];
    }

    private function getData(array $metricsMap)
    {
        $data = array_reduce($this->availablePeriods, function ($c, $i) {
            $c[$i] = array_reduce($this->selectedCompanies, function ($d, $j) {
                $d[$j] = [];
                return $d;
            }, []);
            return $c;
        }, []);

        $standardKeys = [];
        foreach ($this->selectedMetrics as $metric) {
            [$column, $key] = explode('||', $metric, 2);

            if (!isset($standardKeys[$column])) {
                $standardKeys[$column] = [];
            }

            $standardKeys[$column][] = $key;
        }

        if (empty($standardKeys) || !count($this->selectedCompanies)) {
            return [
                'data' => $data,
                'dates' => [],
            ];
        }

        $standardData = InfoTikrPresentation::query()
            ->whereIn('ticker', $this->selectedCompanies)
            ->select(['ticker', 'period', ...array_keys($standardKeys)])
            ->get()
            ->groupBy('period');

        foreach ($standardData as $period => $items) {
            if (!in_array($period, $this->availablePeriods)) {
                continue;
            }

            foreach ($items as $item) {
                foreach ($standardKeys as $column => $keys) {
                    $json = json_decode($item->{$column}, true);

                    foreach ($json as $key => $_value) {
                        $key = explode('|', $key)[0];

                        if (!in_array($key, $keys)) {
                            continue;
                        }

                        $value = [];

                        foreach ($_value as $date => $v) {
                            $val = explode('|', $v[0])[0];
                            $value[$date] = $val ? round((float) $val, 3) : null;
                        }

                        $key = $column . '||' . $key;

                        if (!isset($this->metricAttributes[$key])) {
                            $this->metricAttributes[$key] = [
                                'type' => $metricsMap[$key]['type'] ?? 'bar',
                                'show' => true,
                            ];
                        }

                        $data[$period][$item->ticker][$key] = $this->normalizeValue($value, $period);
                    }
                }
            }
        }

        return [
            'data' => $data,
            'dates' => $this->extractDates($data),
        ];
    }

    private function normalizeValue(array $value, string $period): array
    {
        $val = [];

        foreach ($value as $date => $v) {
            if ($period === 'quarter') {
                $date = Carbon::parse($date)->startOfQuarter();
            } else {
                $date = Carbon::parse($date)->startOfYear();
            }

            $val[$date->toDateString()] = $v;
        }

        return $val;
    }

    private function extractDates(array $data): array
    {
        $dates = array_reduce($this->availablePeriods, function ($c, $i) {
            $c[$i] = [];
            return $c;
        }, []);

        foreach ($data as $period => $item) {
            foreach ($item as $metrics) {
                foreach ($metrics as $values) {
                    $dates[$period] = array_merge($dates[$period], array_keys($values));
                }
            }
        }

        foreach ($dates as $period => $value) {
            $dates[$period] = array_unique($value);
            sort($dates[$period]);
        }

        return $dates;
    }

    private function flattenMetrics($metrics)
    {
        $flattened = [];

        foreach ($metrics as $metric) {
            if ($metric['has_children']) {
                $items = $metric['items'];
            } else {
                $items = [
                    'Dummy' => $metric['items']
                ];
            }

            foreach ($items as $item) {
                $flattened = array_merge($flattened, $item);
            }
        }

        return $flattened;
    }
}
