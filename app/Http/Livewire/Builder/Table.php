<?php

namespace App\Http\Livewire\Builder;

use App\Models\CompanyTableComparison;
use App\Services\TableBuilderService;
use Livewire\Component;

class Table extends Component
{
    public $tab;
    public $notes;
    public $companies;
    public $metrics;
    public $summaries = [];
    public $tableOrder = [];

    protected $listeners = [
        'tabChanged' => 'tabChanged',
        'companiesChanged' => 'companiesChanged',
        'metricsChanged' => 'metricsChanged',
    ];

    public function render()
    {
        $data = TableBuilderService::resolveData($this->companies ?? []);

        return view('livewire.builder.table', [
            'data' => $data['data'],
            'dates' => $data['dates'],
            'allMetrics' => TableBuilderService::options(true),
        ]);
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

    public function updateNote($company, $note)
    {
        $notes = CompanyTableComparison::query()
            ->where('user_id', auth()->id())
            ->where('id', $this->tab['id'])
            ->first()
            ->notes;

        $notes[$company] = $note;

        CompanyTableComparison::query()
            ->where('user_id', auth()->id())
            ->where('id', $this->tab['id'])
            ->update([
                'notes' => $notes,
            ]);

        $this->notes = $notes;
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
        $this->notes = $_tab['notes'];
        $this->tableOrder = $_tab['table_order'];
    }

    private function updateTab()
    {
        $comparison = CompanyTableComparison::query()
            ->where('user_id', auth()->id())
            ->where('id', $this->tab['id'])
            ->first();

        $order = $comparison->table_order;
        $order['data_rows'] = array_filter($order['data_rows'] ?? [], fn ($row) => in_array($row, $this->companies));

        $comparison
            ->update([
                'companies' => $this->companies,
                'metrics' => $this->metrics,
                'summaries' => $this->summaries,
                'order' => $order,
            ]);
    }
}
