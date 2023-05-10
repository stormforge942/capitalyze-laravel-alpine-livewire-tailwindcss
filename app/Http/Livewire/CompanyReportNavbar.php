<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CompanyReportNavbar extends Component
{
    public $navbar;
    public $activeIndex;
    public $activeSubIndex;

    protected $listeners = ['tabClicked', 'tabSubClicked'];

    public function tabClicked($key) {
        $this->activeIndex = $key;
        $this->activeSubIndex = $this->navbar[$key][0]['id'];
        $this->emitUp('tabSubClicked', $this->activeSubIndex);
    }

    public function tabSubClicked($key) {
        $this->activeSubIndex = $key;
    }

    public function render()
    {
        return view('livewire.company-report-navbar');
    }
}
