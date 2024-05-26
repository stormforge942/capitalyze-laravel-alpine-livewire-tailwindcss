<?php

namespace App\Http\Livewire\Builder;

use App\Models\CompanyTableComparison;
use App\Services\TableBuilderService;
use Livewire\Component;

class Table extends Component
{
    public $tab = null;
    public $companies = [];

    private $summaries = [];
    private $metrics = [];
    private $notes = [];
    private $tableOrder = [];
    private $settings = [];

    protected $listeners = [
        'tabChanged' => 'tabChanged',
        'companiesChanged' => 'companiesChanged',
    ];

    public function render()
    {
        // fixes the stale data issue
        if ($this->tab) {
            $this->tabChanged([
                'id' => $this->tab['id'],
                'name' => $this->tab['name'],
            ]);
        }

        $data = TableBuilderService::resolveData($this->companies ?? []);

        return view('livewire.builder.table', [
            'data' => $data['data'],
            'dates' => $data['dates'],
            'allMetrics' => TableBuilderService::options(true),
            'metrics' => $this->metrics,
            'summaries' => $this->summaries,
            'notes' => $this->notes,
            'tableOrder' => $this->tableOrder,
            'settings' => $this->settings,
        ]);
    }

    public function companiesChanged($companies)
    {
        $this->companies = $companies;
        $this->updateTab();
    }

    public function tabChanged($tab)
    {
        $this->tab = $tab;

        /**
         * @var CompanyTableComparison $_tab
         */
        $model = CompanyTableComparison::query()
            ->where('user_id', auth()->id())
            ->where('id', $tab['id'])
            ->first();

        $this->companies = $model->companies;
        $this->metrics = $model->metrics;
        $this->summaries = $model->summaries;
        $this->notes = $model->notes;
        $this->tableOrder = $model->table_order;
        $this->settings = $model->parsedSettings();
    }

    private function updateTab()
    {
        $comparison = CompanyTableComparison::query()
            ->where('user_id', auth()->id())
            ->where('id', $this->tab['id'])
            ->first();

        $comparison->update(['companies' => $this->companies]);
    }
}
