<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LandingPageWaitList extends Component
{
    public $completed = false;

    public function submit()
    {
        $this->completed = true;
    }
    public function render()
    {
        return view('livewire.landing-page-wait-list');
    }
}
