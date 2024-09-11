<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AnalysisChartBox extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public array $company,
        public string $title,
        public array $chart,
        public string $function,
        public string $unit = 'Millions',
        public int $decimalPlaces = 2,
        public bool $enclosed = false,
        public string $defaultType = 'values',
        public bool $hasPercentageMix = true,
        public bool $toggle = true,
        public bool $hasPublicViewToggler = true
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
        return view('components.analysis-chart-box');
    }
}
