<?php

namespace App\Http\Livewire\FilingsSummary;

use Livewire\Component;
use App\Http\Livewire\AllFilings\CommonLayout;
use App\Http\Livewire\AllFilings\FilingsTable;

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

    private $tabs = [
        'all-documents' => 'All Documents',
        'financials' => 'Financials',
        'news' => 'News',
        'registrations-and-prospectuses' => 'Registrations and Prospectuses',
        'proxy-materials' => 'Proxy Materials',
        'ownership' => 'Ownership',
        'other' => 'Other'
    ];

    public function mount($tab)
    {
        $this->selectedTab = $tab;

        if (!in_array($this->selectedTab, array_keys($this->tabs))) {
            $this->selectedTab = 'financials';
        }
    }

    public function updatedSelectedTab()
    {
        $this->checkedCount = 0;
        $this->selectChecked = [];
    }

    public function emitCountInAllfilings($selected, $order = null)
    {
        $data = json_decode($selected) ?? [];
        $this->checkedCount = count($data);
        $this->selectChecked = $data;

        if ($order) {
            $this->emitTo(CommonLayout::class, 'onDateSort', $order);
        }

        $this->emitTo(FilingsTable::class, 'updateFilteredEvent', $this->selectChecked);
    }

    public function handleTabs($tab)
    {
        $tabName = is_array($tab) ? $tab[0] : $tab;
        $this->selectedTab = $tabName;
        $this->emit('passTabNameInParent', $this->selectedTab);
    }

    public function render()
    {
        return view('livewire.filings-summary.all-filings', [
            'tabs' => $this->tabs,
        ]);
    }
}
