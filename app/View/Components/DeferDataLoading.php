<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DeferDataLoading extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $onInit,
        public bool $useAlpine = false,
        public string $contentWrapperClass=""
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
        return view('components.defer-data-loading');
    }
}
