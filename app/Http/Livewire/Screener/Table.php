<?php

namespace App\Http\Livewire\Screener;

use App\Services\ScreenerTableBuilderService;
use Illuminate\Support\Arr;
use Livewire\Component;

class Table extends Component
{
    public $page = 1;

    public $loaded = false;

    public $listeners = ['refreshTable', 'refreshSummary', 'updateView'];

    public array $universal = [];
    public array $financial = [];
    public array $summaries = [];

    public array $columns = [];

    public array $table = [
        'data' => [],
        'summary' => [],
    ];

    public ?array $view = null;

    public function mount()
    {
        $this->makeColumns();
    }

    public function render()
    {
        return view('livewire.screener.table');
    }

    public function refreshTable(array $universal, array $financial, array $summaries)
    {
        $this->page = 1;

        $this->universal = $universal;
        $this->financial = $financial;
        $this->summaries = $summaries;

        $this->load();
    }

    public function updateView(array $view)
    {
        $this->view = $view;

        $this->makeColumns();

        $this->load();
    }

    public function load()
    {
        $this->table = [
            'data' => [],
            'summary' => [],
        ];

        if (count($this->universal) || count($this->financial)) {
            $query = ScreenerTableBuilderService::makeQuery($this->universal, $this->financial);

            $this->table['data'] = ScreenerTableBuilderService::generateTableData(
                $query->clone(),
                $this->columns,
                $this->page,
            );

            $this->refreshSummary($this->summaries, $query->clone());
        }

        $this->loaded = true;
    }

    public function refreshSummary(array $summaries, $query = null)
    {
        $this->summaries = $summaries;

        $this->table['summary'] = [];

        if (!$query) {
            $query = ScreenerTableBuilderService::makeQuery($this->universal, $this->financial);
        }

        $this->table['summary'] = ScreenerTableBuilderService::generateSummary(
            $query,
            $this->summaries,
            $this->columns,
        );
    }

    public function prevPage()
    {
        $this->page = max(1, $this->page - 1);

        $this->load();
    }

    public function nextPage()
    {
        $this->page = $this->page + 1;

        $this->load();
    }

    private function makeColumns()
    {
        $this->columns = [];

        $options = ScreenerTableBuilderService::options(true);

        foreach ($this->resolveSelect() as $item) {
            $option = $options[$item['metric']];
            $key = 'mapping.' . ($item['type'] === 'value' ? 'self' : 'yoy_change');

            $column = data_get($option, $key);

            if (!$column) continue;

            $title = $option['title'] . ($item['type'] !== 'value' ? ' - % Growth YoY' : '');

            foreach ($item['dates'] as $date) {
                $formattedDate = null;

                if ($item['period'] === 'annual') {
                    $formattedDate = (int) explode(" ", $date)[1];
                } else {
                    [$quarter, $year] = explode(" ", $date);
                    $quarter = (int) ltrim($quarter, "Q");

                    $formattedDate = [(int) $year, (int) $quarter];
                }

                $accessor = $column . "_" . implode("_", Arr::wrap($formattedDate));

                $this->columns[] = [
                    'title' => $title . "<br>(" . ($date) . ")",
                    'column' => $column,
                    'accessor' => $accessor,
                    'period' => $item['period'],
                    'date' => $formattedDate,
                ];
            }
        }
    }

    private function resolveSelect(): array
    {
        return data_get($this->view, 'config', []);
    }
}
