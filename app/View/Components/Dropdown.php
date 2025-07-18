<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Dropdown extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $placement = 'bottom',
        public bool $shadow = false,
        public bool $fullWidthTrigger = false,
        public int $offsetDistance = 4,
        public bool $teleport = false,
        public bool $disabled = false,
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.dropdown');
    }
}
