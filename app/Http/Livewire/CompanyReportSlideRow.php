<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CompanyReportSlideRow extends Component
{
    public $data;
    public $rows;
    public $tableDates;
    public $ticker;
    public $isRight = false;
    public $formulaValues;

    public function mount($data, $isRight = false, $formulaValues = [])
    {
        $this->data = $data;
        $this->isRight = $isRight;
        $this->formulaValues = $formulaValues;
        $this->generateRows();
    }

    public function generateAttribute($value)
    {
        return [
            'hash' => $value['hash'],
            'ticker' => $this->ticker,
            'value' => $value['value']
        ];
    }
    public function generateRows()
    {
        $rows = [];

        foreach ($this->data['Income Statement'] as $key => $value) {
            $response = [];

            foreach ($value as $date => $data) {
                $this->tableDates[] = $date;

                if (in_array('|', str_split($data[0]))) {

                    $array = explode('|', $data[0]);

                    $response[$date]['value'] = $this->convertToNumber($array[0]);
                    $response[$date]['hash'] = $array[1];
                }
            }

            $rows[] = [
                'title' => $key,
                'values' => $response
            ];
        }

        $this->tableDates = array_unique($this->tableDates);
        $this->rows = $rows;
    }

    public function convertToNumber($value)
    {
        if (str_contains($value, '-')) {
            return $value;
        }

        if (str_contains($value, '%') || !is_numeric($value)) {
            return $value;
        }

        if (str_contains($value, '.') || str_contains($value, ',')) {
            $float = floatval(str_replace(',', '', $value));

            $value = intval($float);
        }

        return number_format($value);
    }

    public function render()
    {
        return view('livewire.company-report-slide-row');
    }
}
