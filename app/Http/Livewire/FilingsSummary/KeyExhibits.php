<?php

namespace App\Http\Livewire\FilingsSummary;

use Livewire\Component;

class KeyExhibits extends Component
{
    public $company;
    public $ticker;
    public $selectedTab = "articles-inc-bylaws";

    public function updatedSelectedTab($tab)
    {
        $this->emit('passTabNameInParent', $tab);
    }

    public function render()
    {
        return view('livewire.filings-summary.key-exhibits');
    }
}
