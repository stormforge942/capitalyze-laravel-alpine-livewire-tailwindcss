<?php

namespace App\Http\Livewire\Screener;

use App\Services\ScreenerTableBuilderService;
use Livewire\Component;

class FinancialCriteria extends Component
{
    protected $listeners = [
        'refreshFinancialCriteriaCounter' => 'refreshFinancialCriteriaCounter',
        'refreshComponent' => '$refresh'
    ];

    public $options = [];
    public $selected = [];
    public $value = [];
    public $dates;
    public $criteriaId;
    public $counter = 0;

    public function mount()
    {
        $this->options = ScreenerTableBuilderService::options();
    }

    public function addNewFinancialCriteria($data)
    {
        $this->emit('addFinancialCriteriaToSelected', $data);
    }

    public function removeFinancialCriteria()
    {
        $this->emit('removeFinancialCriteria', $this->criteriaId);
    }

    public function render()
    {
        return view('livewire.screener.financial-criteria');
    }

    public function refreshFinancialCriteriaCounter($counter)
    {
        if(isset($counter[$this->criteriaId])) {
            $this->counter = $counter[$this->criteriaId];
        }

        if(!isset($counter[$this->criteriaId])) {
            $this->counter = 0;
        }

        $this->emit('refreshComponent');
    }
}
