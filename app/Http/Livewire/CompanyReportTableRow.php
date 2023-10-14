<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CompanyReportTableRow extends Component
{
    public $data = [];
    public $index = 0;
    public $open = true;
    public $selected;
    public $attr = "";
    public $selectedRows = [];

    public function mount($data, $index = 0, $selectedRows = [])
    {
        $this->data = $data;
        $this->index = $index;
        $this->selected = in_array($data['title'], $selectedRows);
        $this->selectedRows = $selectedRows;
    }

    public function generateAttribute($value)
    {
        if ($value['empty']) {
            return "";
        }

        return '{"hash":"' . $value['hash'] . '","ticker":"' . $value['ticker'] . '","value":"$' . $value['value'] . '"}';
    }

    public function render()
    {
        return view('livewire.company-report-table-row');
    }

    public function select()
    {
        if ($this->selected) {
            $this->emit('unselectRow', $this->data['title']);
            $this->selected = false;
            return;
        }

        $notEmpty = false;

        foreach ($this->data['values'] as $value) {
            if (!$value['empty']) {
                $notEmpty = true;
                break;
            }
        }

        if ($notEmpty) {
            $this->emit('selectRow', $this->data['title'], $this->data['values']);
            $this->selected = true;
        }
    }

    public function toggle()
    {
        $this->open = !$this->open;
    }
}
