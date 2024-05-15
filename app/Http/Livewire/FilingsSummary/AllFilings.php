<?php

namespace App\Http\Livewire\FilingsSummary;

use App\Http\Livewire\AllFilings\FilingsTable;
use Livewire\Component;

class AllFilings extends Component
{
    public $company;
    public $ticker;
    public $selectedTab;
    public $checkedCount = 0;
    public $selectChecked = [];

    protected $listeners = [
        'handleAllFilingsTabs' => 'handleTabs',
        'emitCountInAllfilings' => 'emitCountInAllfilings',
    ];

    public function emitCountInAllfilings($selected)
    {
        $data = json_decode($selected) ?? [];
        $this->checkedCount = count($data);
        $this->selectChecked = $data;

        $this->emitTo(FilingsTable::class, 'updateFilteredEvent', $this->selectChecked);
    }

    public function handleTabs($tab)
    {
        $tabName = is_array($tab) ? $tab[0] : $tab;
        $this->selectedTab = $tabName;
        $this->emit('passTabNameInParent', $this->selectedTab);
    }

    public function updateSelectedTab($tabName)
    {
        $this->selectedTab = $tabName;
    }

    public function mount() {
        $this->selectedTab = 'financials';
    }

    public function handleFilingBrowserType($val)
    {
        $this->emit('handleFilingBrowserType', true);
    }

    public function render()
    {
        return view('livewire.filings-summary.all-filings', ['selectedTab'=>$this->selectedTab]);
    }
}
