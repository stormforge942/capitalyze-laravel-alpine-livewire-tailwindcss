<?php

namespace App\Http\Livewire\FilingsSummary;

use App\Http\Livewire\KeyExhibits\ExhibitsTable;
use Livewire\Component;

class KeyExhibits extends Component
{
    public $company;
    public $ticker;
    public $selectedTab = "articles-inc-bylaws";
    public $checkedCount = 0;
    public $selectChecked = [];

    protected $listeners = [
        'handleKeyExhibitsTabs' => 'handleTabs',
        'emitCountInKeyExhibits' => 'emitCountInKeyExhibits',
    ];

    public function emitCountInKeyExhibits($selected)
    {
        $data = json_decode($selected) ?? [];
        $this->checkedCount = count($data);
        $this->selectChecked = $data;

        $this->emitTo(ExhibitsTable::class, 'updateFilteredEvent', $this->selectChecked);
    }

    public function handleTabs($tab)
    {
        $tabName = is_array($tab) ? $tab[0] : $tab;
        $this->selectedTab = $tabName;
        $this->emit('passTabNameInParent', $this->selectedTab);
    }

    public function updatedSelectedTab($tab)
    {
        $this->emit('passTabNameInParent', $tab);
    }

    public function render()
    {
        return view('livewire.filings-summary.key-exhibits');
    }
}
