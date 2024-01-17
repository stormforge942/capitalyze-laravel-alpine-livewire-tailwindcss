<?php

namespace App\Http\Livewire\CompanyAnalysis;

use Livewire\Component;

class Page extends Component
{
    public $company;

    public function render()
    {
        return view('livewire.company-analysis.page', [
            'tabs' => [
                Revenue::class,
                Efficiency::class,
                CapitalAllocation::class
            ]
        ]);
    }
}
