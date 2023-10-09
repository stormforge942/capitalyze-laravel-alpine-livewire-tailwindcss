<?php

namespace App\Http\Livewire\Ownership;

use App\Models\Company;
use Livewire\Component;

class Page extends Component
{
    public Company $company;
    public array $tabs;

    public function mount(Company $company)
    {
        $this->company = $company;

        $this->tabs = [
            'shareholders' => [
                'title' => 'Shareholders',
            ],
            'insiders' => [
                'title' => 'Insiders',
            ],
        ];
    }

    public function render()
    {
        return view('livewire.ownership.page');
    }
}
