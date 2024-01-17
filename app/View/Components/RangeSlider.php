<?php

namespace App\View\Components;

use Illuminate\View\Component;

class RangeSlider extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public int $min,
        public int $max,
        public ?array $value = null,
    ) {
        $this->value = $value ?? [$min, $max];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.range-slider');
    }
}
