<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Button extends Component
{
    public $class;
    public $text;
    public $icon = null;

    public function mount($text, $class = 'primary', $icon = null)
    {
        $this->text = $text;
        $this->class = 'btn-' . $class;
        $this->icon = $icon;
    }

    public function render()
    {
        return view('livewire.button');
    }
}
