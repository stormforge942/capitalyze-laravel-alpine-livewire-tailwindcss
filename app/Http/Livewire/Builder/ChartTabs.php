<?php

namespace App\Http\Livewire\Builder;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\CompanyChartComparison;
use Illuminate\Support\Arr;

class ChartTabs extends Component
{
    public int $activeTab = 0;
    public array $tabs = [];

    public function mount()
    {
        $cols = ['id', 'name'];

        $this->tabs = CompanyChartComparison::query()
            ->where('user_id', Auth::id())
            ->oldest()
            ->get($cols)
            ->toArray();

        if (!count($this->tabs)) {
            $this->tabs[] = CompanyChartComparison::query()
                ->where('user_id', Auth::id())
                ->create([
                    'name' => 'Untitled',
                    'companies' => [],
                    'metrics' => [],
                    'filters' => [],
                    'metric_attributes' => [],
                    'user_id' => Auth::id(),
                ])
                ->only($cols);
        }

        if (!$this->activeTab) {
            $activeTab = session('builder.chart.activeTab');

            if ($activeTab && Arr::first($this->tabs, fn ($tab) => $tab['id'] == $activeTab)) {
                $this->activeTab = $activeTab;
            } else {
                $this->activeTab = $this->tabs[count($this->tabs) - 1]['id'];
            }
        }
    }

    public function init()
    {
        $tab = Arr::first($this->tabs, fn ($tab) => $tab['id'] == $this->activeTab);

        $this->emitTo(Chart::class, 'tabChanged', $tab);
    }

    public function render()
    {
        return view('livewire.builder.chart-tabs');
    }

    public function addTab()
    {
        $this->tabs[] = CompanyChartComparison::query()
            ->where('user_id', Auth::id())
            ->create([
                'name' => 'Untitled',
                'companies' => [],
                'metrics' => [],
                'filters' => [],
                'metric_attributes' => [],
                'user_id' => Auth::id(),
            ])
            ->only(['id', 'name']);

        $this->changeTab($this->tabs[count($this->tabs) - 1]['id']);
    }

    public function changeTab($id)
    {
        $tab = Arr::first($this->tabs, fn ($tab) => $tab['id'] == $id);

        abort_if(!$tab, 403);

        if ($this->activeTab != $id) {
            $this->emitTo(Chart::class, 'tabChanged', $tab);
        }

        $this->activeTab = $id;

        session(['builder.chart.activeTab' => $id]);
    }

    public function updateTab($id, $name)
    {
        abort_if(!Arr::first($this->tabs, fn ($tab) => $tab['id'] == $id), 403);

        CompanyChartComparison::query()
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->update(['name' => $name]);

        foreach ($this->tabs as $idx => $tab) {
            if ($tab['id'] == $id) {
                $this->tabs[$idx]['name'] = $name;
                break;
            }
        }
    }

    public function deleteTab($id)
    {
        abort_if(!Arr::first($this->tabs, fn ($tab) => $tab['id'] == $id), 403);

        CompanyChartComparison::query()
            ->where('id', $id)
            ->delete();

        $this->tabs = array_values(array_filter($this->tabs, fn ($tab) => $tab['id'] != $id));

        if (!count($this->tabs)) {
            $this->addTab();
            return;
        }

        if ($this->activeTab == $id) {
            $this->changeTab($this->tabs[count($this->tabs) - 1]['id']);
        }
    }
}
