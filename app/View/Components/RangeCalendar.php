<?php

namespace App\View\Components;

use Illuminate\View\Component;

class RangeCalendar extends Component
{
    public function __construct(public string $placement = 'bottom-end')
    {
    }

    public function render()
    {
        return view('components.range-calendar');
    }
}
