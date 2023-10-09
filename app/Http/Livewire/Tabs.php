<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Tabs extends Component
{
    public array $tabs = [];
    public ?string $active = null;

    public function mount(array $tabs = [], string $active = null)
    {
        $this->tabs = $tabs;
        $this->active = $active ?: array_key_first($tabs);
    }

    public function render()
    {
        return view('livewire.tabs');
    }
}
