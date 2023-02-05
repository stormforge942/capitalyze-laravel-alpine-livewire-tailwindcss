<?php

namespace App\View\Components;

use App\Models\Company;
use Illuminate\View\Component;

class CompanyLayout extends Component
{
    public $company;

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('layouts.company');
    }
}
