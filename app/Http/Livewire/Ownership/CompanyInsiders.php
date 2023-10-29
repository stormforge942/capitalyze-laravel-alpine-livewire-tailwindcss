<?php

namespace App\Http\Livewire\Ownership;

use App\Http\Livewire\AsTab;
use Livewire\Component;

class CompanyInsiders extends Component
{
    use AsTab;

    public string $ticker;

    public function mount(array $data = [])
    {
        $this->ticker = $data['company']['ticker'];
    }

    public function render()
    {
        return <<<'blade'
            <livewire:ownership.company-insiders-table :ticker="$ticker" />
        blade;
    }
}
