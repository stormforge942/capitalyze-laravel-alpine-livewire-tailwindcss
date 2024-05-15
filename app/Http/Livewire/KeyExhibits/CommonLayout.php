<?php

namespace App\Http\Livewire\KeyExhibits;

use Livewire\Component;

class CommonLayout extends Component
{
    public $data;
    public $order;
    public $col;
    public $company;
    public $checkedCount;
    public $selectedTab;
    public $search;
    public $filtered;
    public $dateSortOrder = '';
    public $selectChecked = [];

    protected $listeners = ['onDateSort', 'onSearch'];

    public function onSearch($query)
    {
        $this->search = $query;
        $this->emitTo(ExhibitsTable::class, 'updateSearch', $query);
    }

    public function onDateSort($order)
    {
        $this->dateSortOrder = $order;
        $this->emitTo(ExhibitsTable::class, 'updateDateSortOrder', $order);
    }

    public function handleSorting($column)
    {
        $this->emit('sortingOrder', [$column, $this->order]);
    }
    
    public function render()
    {
        return view('livewire.key-exhibits.common-layout');
    }

    public function mount()
    {
        $this->filtered = [];
    }
}
