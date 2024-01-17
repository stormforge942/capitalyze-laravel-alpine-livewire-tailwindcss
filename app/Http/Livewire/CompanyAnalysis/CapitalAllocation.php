<?php

namespace App\Http\Livewire\CompanyAnalysis;

use App\Http\Livewire\AsTab;
use Livewire\Component;

class CapitalAllocation extends Component
{
    use AsTab;

    public function mount($data)
    {
        $this->data = $data;
    }

    public function render()
    {
        return view('livewire.company-analysis.capital-allocation', [
            'company' => $this->data['company'],
        ]);
    }
}
