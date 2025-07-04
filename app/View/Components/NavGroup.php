<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NavGroup extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $name,
        public array $items,
        public bool $collapsed = false,
    ) {
        if (collect($this->items)->firstWhere('active', true)) {
            $this->collapsed = false;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.nav-group');
    }
}
