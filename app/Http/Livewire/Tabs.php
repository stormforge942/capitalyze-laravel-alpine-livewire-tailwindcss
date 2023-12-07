<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Tabs extends Component
{
    public array $tabs = [];
    public ?string $active = null;
    public array $data = [];
    public bool $ssr = true;

    public function mount(
        array $tabs = [],
        string $active = null,
        array $data = [],
        bool $ssr = true,
    ) {
        $this->ssr = $ssr;
        $this->tabs = [];
        $this->data = $data;

        foreach ($tabs as $tab) {
            $this->tabs[$tab::key()] = [
                'title' => $tab::title(),
                'component' => $tab,
                'key' => $tab::key(),
            ];
        }

        $this->active = request()->query('tab', $active);
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
