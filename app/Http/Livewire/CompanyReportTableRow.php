<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CompanyReportTableRow extends Component
{
    public $data = [];
    public $index = 0;
    public $open = false;

    public function mount($data, $index = 0)
    {
        $this->data = $data;
        $this->index = $index;
    }

    public function render()
    {
        return view('livewire.company-report-table-row');
    }

    public function toggle()
    {
        $this->open = !$this->open;
    }
}
