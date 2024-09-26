<?php

namespace App\Http\Livewire\Screener;

use App\Services\ScreenerTableBuilderService;
use Livewire\Component;

class Table extends Component
{
    public $page = 1;

    public $loaded = false;

    public $listeners = ['refreshTable', 'refreshSummary'];

    public array $universal = [];
    public array $financial = [];
    public array $summaries = [];

    public $table = [
        'data' => [],
        'summary' => [],
    ];

    public function mount()
    {
        $this->load();
    }

    public function render()
    {
        return view('livewire.screener.table');
    }

    public function refreshTable(array $universal, array $financial, array $summaries)
    {
        $this->loaded = false;

        $this->universal = $universal;
        $this->financial = $financial;
        $this->summaries = $summaries;
    }

    public function load()
    {
        if (count($this->universal) || count($this->financial)) {
            $query = ScreenerTableBuilderService::makeQuery($this->universal, $this->financial);

            $this->table['data'] = ScreenerTableBuilderService::generateTableData(
                $query,
                $this->resolveSelect(),
                $this->page,
            );

            $this->refreshSummary($this->summaries);
        }

        $this->loaded = true;
    }

    public function refreshSummary(array $summaries)
    {
        $this->summaries = $summaries;

        if ($this->summaries) {
            $this->table['summary'] = ScreenerTableBuilderService::generateSummary(
                ScreenerTableBuilderService::makeQuery($this->universal, $this->financial),
                $this->table['summary'],
                $this->resolveSelect(),
            );
        }
    }

    private function resolveSelect()
    {
        return [
            'c.symbol',
            'c.registrant_name',
            'c.country',
            'c.exchange',
            'c.sic_group',
            'c.sic_description',
        ];
    }
}
