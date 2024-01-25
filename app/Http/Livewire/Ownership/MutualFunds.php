<?php

namespace App\Http\Livewire\Ownership;

use App\Http\Livewire\AsTab;
use Livewire\Component;

class MutualFunds extends Component
{
    use AsTab;

    public string $ticker;
    public array $filters = [
        'periodRange' => null,
        'search' => ''
    ];

    public function mount(array $data = [])
    {
        $this->ticker = $data['company']['ticker'];
    }

    public function render()
    {
        return view('livewire.ownership.mutual-funds');
    }

    public function updatedFilters()
    {
        $this->emitTo(MutualFundsTable::class, 'filtersChanged', $this->filters);
    }
}
