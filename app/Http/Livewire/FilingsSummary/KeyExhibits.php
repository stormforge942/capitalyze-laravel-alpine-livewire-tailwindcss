<?php

namespace App\Http\Livewire\FilingsSummary;

use App\Http\Livewire\KeyExhibits\CommonLayout;
use App\Http\Livewire\KeyExhibits\ExhibitsTable;
use Livewire\Component;

class KeyExhibits extends Component
{
    public $company;
    public $ticker;
    public $selectedTab;
    public $checkedCount = 0;
    public $selectChecked = [];

    protected $listeners = [
        'handleKeyExhibitsTabs' => 'handleTabs',
        'emitCountInKeyExhibits' => 'emitCountInKeyExhibits',
        'resetExhibitsFilters' => 'resetExhibitsFilters',
    ];

    private $tabs = [
        'articles-inc-bylaws' => 'Articles of Inc. and Bylaws',
        'credit-agreement' => 'Credit Agreement',
        'indentures' => 'Indentures',
        'material-contracts' => 'Material Contracts',
        'plans-reorganization' => 'Plans of Reorganization',
        'underwriting-agreements' => 'Underwriting Agreements'
    ];

    public function mount($tab)
    {
        $this->selectedTab = $tab;

        if (!in_array($this->selectedTab, array_keys($this->tabs))) {
            $this->selectedTab = 'articles-inc-bylaws';
        }
    }

    public function updatedSelectedTab()
    {
        $this->checkedCount = 0;
        $this->selectChecked = [];
    }

    public function emitCountInKeyExhibits($selected, $order = null)
    {
        $data = json_decode($selected) ?? [];
        $this->checkedCount = count($data);
        $this->selectChecked = $data;

        if ($order) {
            $this->emitTo(CommonLayout::class, 'onDateSort', $order);
        }

        $this->emitTo(ExhibitsTable::class, 'updateFilteredEvent', $this->selectChecked);
    }

    public function handleTabs($tab)
    {
        $tabName = is_array($tab) ? $tab[0] : $tab;
        $this->selectedTab = $tabName;
    }

    public function render()
    {
        return view('livewire.filings-summary.key-exhibits', [
            'tabs' => $this->tabs,
        ]);
    }
}
