<?php

namespace App\Http\Livewire\Builder;

use App\Models\CompanyChartComparison;
use Illuminate\Support\Arr;
use Livewire\Component;

class Chart extends Component
{
    public $tab = [];

    protected $listeners = [
        'tabChanged' => 'tabChanged',
        'companiesChanged' => 'companiesChanged',
        'metricsChanged' => 'metricsChanged',
    ];

    public function render()
    {
        return view('livewire.builder.chart');
    }

    public function tabChanged($tab)
    {
        $this->tab = $tab;
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
