<?php

namespace App\Http\Livewire\Builder;

use App\Models\CompanyTableComparison;
use Livewire\Component;

class Table extends Component
{
    public $tab;
    public $companies;
    public $metrics;
    public $summaries;

    protected $listeners = [
        'tabChanged' => 'tabChanged',
        'companiesChanged' => 'companiesChanged',
        'metricsChanged' => 'metricsChanged',
    ];

    public function render()
    {
        return view('livewire.builder.table');
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

    public function tabChanged($tab)
    {
        $this->tab = $tab;

        $_tab = CompanyTableComparison::query()
            ->where('user_id', auth()->id())
            ->where('id', $tab['id'])
            ->first();

        $this->companies = $_tab['companies'];
        $this->metrics = $_tab['metrics'];
        $this->summaries = $_tab['summaries'];
    }

    private function updateTab()
    {
        CompanyTableComparison::query()
            ->where('user_id', auth()->id())
            ->where('id', $this->tab['id'])
            ->update([
                'companies' => $this->companies,
                'metrics' => $this->metrics,
                'summaries' => $this->summaries,
            ]);
    }
}
