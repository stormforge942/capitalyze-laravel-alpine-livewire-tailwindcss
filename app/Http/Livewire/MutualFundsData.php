<?php

namespace App\Http\Livewire;

use App\Models\MutualFunds;
use Livewire\Component;

class MutualFundsData extends Component
{
    public $title;
    public $data;

    protected $listeners = ['mutualFundsDataUpdate' => 'update'];

    public function update($cik) {
        $this->title = $cik;
        $this->data = MutualFunds::where('cik', $this->title)->get()->toArray();
    }

    public function mount() {
        $this->title = "Loading...";
        $this->data = [];
    }

    public function render()
    {
        return view('livewire.mutual-funds-data');
    }
}
