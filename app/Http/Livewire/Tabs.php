<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Tabs extends Component
{
    public array $tabs = [];
    public ?string $active = null;
    public array $data = [];

    public function mount(
        array $tabs = [],
        string $active = null,
        array $data = []
    ) {
        $this->tabs = [];
        $this->data = $data;

        foreach ($tabs as $tab) {
            $this->tabs[$tab::key()] = [
                'title' => $tab::title(),
                'component' => $tab,
            ];
        }

        if (!in_array($active, array_keys($this->tabs))) {
            $active = array_key_first($this->tabs);
        }

        $this->active = $active;
    }

    public function render()
    {
        return view('livewire.tabs');
    }

    public function changeTab(string $key)
    {
        if (!in_array($key, array_keys($this->tabs))) {
            return;
        }

        $this->active = $key;
        $this->emitUp('tabChanged', $key);
    }
}
