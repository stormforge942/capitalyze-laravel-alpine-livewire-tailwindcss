<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CompanyReportTableRow extends Component
{
    public $data = [];
    public $index = 0;
    public $open = true;
    public $reverse = false;
    public $selected;
    public $attr = "";
    public $selectedRows = [];
    public $itemKey = 0;

    protected $listeners = ['resetSelection'];

    public function mount($data, $index = 0, $selectedRows = [], $reverse = false, $itemKey = 0)
    {
        $this->data = $data;
        $this->itemKey = $itemKey;
        $this->index = $index;
        $this->selected = in_array($data['title'], $selectedRows);
        $this->selectedRows = $selectedRows;
        $this->reverse = $reverse;
    }

    public function getIsCheckedProperty(){
        if(array_key_exists($this->itemKey, $this->selectedRows)){
            return true;
        }
        else {
            return false;
        }
    }

    public function generateAttribute($value)
    {
        $string = '';

        if ($value['empty']) {
            return "";
        }

        if (array_key_exists('secondHash', $value)) {
            $string = $value['secondHash'] ? ',"secondHash":"' . $value['secondHash'] . '"' : '';
        }

        return '{"hash":"' . $value['hash'] . '"' . $string . ',"ticker":"' . $value['ticker'] . '","value":"$' . $value['value'] . '"}';
    }

    public function render()
    {
        return view('livewire.company-report-table-row');
    }

    public function resetSelection($title) {
        if ($title === $this->data['title']) {
            $this->selected = false;
        }
    }

    public function select()
    {
        if ($this->getIsCheckedProperty()) {
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
