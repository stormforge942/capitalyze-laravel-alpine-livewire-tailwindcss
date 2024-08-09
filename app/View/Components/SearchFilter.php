<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SearchFilter extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $placeholder = "Search...",
        public string $fontSize = "sm+",
        public string $py="4",
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.search-filter');
    }
}
