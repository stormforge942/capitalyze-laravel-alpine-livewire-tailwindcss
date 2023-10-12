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

    public function select()
    {
        $notEmpty = false;

        foreach ($this->data['values'] as $value) {
            if (!$value['empty']) {
                $notEmpty = true;
                break;
            }
        }

        if ($notEmpty) {
            $this->emit('selectRow', $this->data['title'], $this->data['values']);
        }
    }

    public function toggle()
    {
        $this->open = !$this->open;
    }
}
