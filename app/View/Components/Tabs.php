<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Tabs extends Component
{
    public function __construct(public array $tabs = [], public int $active = 0)
    {
    }

    public function render()
    {
        return view('components.tabs');
    }
}
