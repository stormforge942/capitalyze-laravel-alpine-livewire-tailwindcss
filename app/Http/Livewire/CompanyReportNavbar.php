<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CompanyReportNavbar extends Component
{
    public $navbar;
    public $activeIndex;
    public $activeSubIndex;

    protected $listeners = ['tabClicked', 'tabSubClicked', 'navbarUpdated'];

    public function tabClicked($key) {
        $this->activeIndex = $key;
        $this->activeSubIndex = $this->navbar[$key][0]['id'];
        $this->emitUp('tabSubClicked', $this->activeSubIndex);
        $this->emit('contentChanged');
    }

    public function tabSubClicked($key) {
        $this->activeSubIndex = $key;
        $this->emit('contentChanged');
    }

    public function mount($navbar, $activeIndex, $activeSubIndex)
    {
        $this->navbar = $navbar;
        $this->activeIndex = $activeIndex;
        $this->activeSubIndex = $activeSubIndex;
    }

    public function navbarUpdated($navbar, $activeIndex, $activeSubIndex)
    {
        $this->navbar = $navbar;
        $this->activeIndex = $activeIndex;
        $this->activeSubIndex = $activeSubIndex;
    }

    public function render()
    {
        return view('livewire.company-report-navbar');
    }
}
