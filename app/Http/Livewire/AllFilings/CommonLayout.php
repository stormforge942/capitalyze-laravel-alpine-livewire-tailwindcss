<?php

namespace App\Http\Livewire\AllFilings;

use Livewire\Component;

class CommonLayout extends Component
{
    public $data;
    public $order;
    public $col;
    public $filtered;
    public $company;
    public $search;
    public $checkedCount;
    public $selectedTab;
    public $dateSortOrder = '';
    public $selectChecked = [];

    protected $listeners = ['onDateSort', 'onSearch'];

    public function onSearch($query)
    {
        $this->search = $query;
        $this->emitTo(FilingsTable::class, 'updateSearch', $query);
    }

    public function onDateSort($order)
    {
        $this->dateSortOrder = $order;
        $this->emitTo(FilingsTable::class, 'updateDateSortOrder', $order);
    }

    public function handleSorting($column)
    {
        $this->emit('sortingOrder', [$column, $this->order]);
    }

    public function mount()
    {
        if ($this->selectedTab !== 'all-documents') {
            $filtered = falingsSummaryTabFilteredValue($this->selectedTab)['params'] ?? [];
            $this->filtered = $filtered;
        } else {
            $this->filtered = [];
        }
    }

    public function render()
    {
        return view('livewire.all-filings.common-layout');
    }
}
