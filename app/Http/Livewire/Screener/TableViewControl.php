<?php

namespace App\Http\Livewire\Screener;

use Livewire\Component;
use App\Models\ScreenerTab;
use App\Http\Livewire\Screener\Table;

class TableViewControl extends Component
{
    public $active = 'default';
    public $views;
    public $tabId;

    public function mount(ScreenerTab $tab)
    {
        $this->tabId = $tab->id;

        $this->views = [
            [
                'id' => 'default',
                'name' => 'Screener Data',
            ],
            ...($tab->views ?? [])
        ];

        $activeView = collect($this->views)->firstWhere('id', $tab->view);

        $this->active = $activeView ? $activeView['id'] : 'default';

        $this->updateTable();
    }

    public function render()
    {
        $this->active = collect($this->views)->firstWhere('id', $this->active)
            ? $this->active
            : 'default';

        return view('livewire.screener.table-view-control');
    }

    public function updated($field)
    {
        if ($field === 'active') {
            $this->viewChanged();
        }
    }

    public function addView(string $name)
    {
        if (empty(trim($name))) {
            return;
        }

        $tab = ScreenerTab::query()
            ->where('user_id', auth()->id())
            ->find($this->tabId);

        $view = $tab->addView([
            'name' => $name,
            'config' => [],
        ]);

        $this->views[] = $view;

        $this->active = $view['id'];

        $this->viewChanged();
    }

    private function viewChanged()
    {
        ScreenerTab::query()
            ->where('user_id', auth()->id())
            ->find($this->tabId)
            ->update(['view' => $this->active]);

        $this->updateTable();
    }

    public function updateView(array $view)
    {
        $tab = ScreenerTab::query()
            ->where('user_id', auth()->id())
            ->find($this->tabId);

        $tab->updateViewConfig($view['id'], $view['config']);

        $this->updateTable();
    }

    public function updateTable()
    {
        $this->emitTo(Table::class, 'updateView', collect($this->views)->firstWhere('id', $this->active));
    }
}
