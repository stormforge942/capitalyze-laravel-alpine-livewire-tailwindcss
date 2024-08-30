<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;

class ComapanyFilingsSummary extends Component
{
    public $tabName;
    public $company;
    public $ticker;
    public $period;
    public $childTabName;
    public $loading = true;
    public $selectedSubTabs;

    protected $listeners = ['handleFilingsSummaryTab' => 'setTabName', 'passTabNameInParent'];

    private $tabs = [
        'summary' => [
            'title' => 'Filings Summary',
            'key' => 'summary'
        ],
        'all-filings' => [
            'title' => 'All Filings',
            'key' => 'all-filings'
        ],
        'key-exhibits' => [
            'title' => 'Key Exhibits',
            'key' => 'key-exhibits'
        ],
        'earning-presentations' => [
            'title' => 'Earning Presentations',
            'key' => 'earning-presentations'
        ]
    ];

    public function mount(Request $request)
    {
        $this->tabName = $request->query('tab');

        $this->selectedSubTabs = collect($this->tabs)->map(fn($_, $tab) => request()->query($tab))->toArray();

        if (!in_array($this->tabName, array_keys($this->tabs))) {
            $this->tabName = 'summary';
        }
    }

    public function setTabName($tab)
    {
        $this->loading = true;

        $selectedTab = is_array($tab) ? $tab[0] : $tab;

        $this->tabName = in_array($selectedTab, array_keys($this->tabs)) ? $selectedTab : 'summary';

        if (is_array($tab)) {
            $this->emit('handleAllFilingsTabs', $tab[1]);
        } else {
            $this->selectedSubTabs[$this->tabName] = null;
        }
    }

    public function passTabNameInParent($tab)
    {
        $this->childTabName = $tab;
        $this->loading = false;
    }

    public function render()
    {
        return view('livewire.comapany-filings-summary', [
            'tabs' => $this->tabs
        ]);
    }
}
