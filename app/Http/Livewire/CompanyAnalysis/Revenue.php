<?php

namespace App\Http\Livewire\CompanyAnalysis;

use App\Http\Livewire\AsTab;
use Livewire\Component;

class Revenue extends Component
{
    use AsTab;

    public function mount($data)
    {
        $this->data = $data;
    }

    public function render()
    {
        return view('livewire.company-analysis.revenue', [
            'company' => $this->data['company'],
        ]);
    }
}
