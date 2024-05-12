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
    public $data;

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
        $this->updateData();
        $this->updateTab();
    }

    public function metricsChanged($metrics)
    {
        $this->metrics = $metrics;
        $this->updateData();
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

        $this->updateData();
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

    private function updateData()
    {
        $this->data = TableBuilderService::resolveData($this->companies ?? [], $this->metrics ?? []);
    }
}
