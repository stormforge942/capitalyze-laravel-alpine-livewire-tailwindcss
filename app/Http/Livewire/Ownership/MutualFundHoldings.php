<?php

namespace App\Http\Livewire\Ownership;

use Livewire\Component;
use App\Http\Livewire\AsTab;

class MutualFundHoldings extends Component
{
    use AsTab;

    public $fund;
    public array $filters = [
        'periodRange' => null,
        'search' => ''
    ];

    public static function title(): string
    {
        return 'Holdings';
    }

    public function mount(array $data = [])
    {
        $this->fund = $data['fund'];
    }

    public function render()
    {
        return view('livewire.ownership.mutual-fund-holdings');
    }

    public function updatedFilters()
    {
        $this->emitTo(MutualFundHoldingsTable::class, 'filtersChanged', $this->filters);
    }
}
