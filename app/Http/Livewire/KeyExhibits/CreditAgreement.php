<?php

namespace App\Http\Livewire\KeyExhibits;

use Livewire\Component;

class CreditAgreement extends Component
{
    public $data;
    public function render()
    {
        for($i=0; $i<100; $i++){
            $this->data[] = [
                'name'=>'10-K',
                'desc' => 'Other event, financial statement and exhibits',
                'date_1' =>'05/04/2023', 
                'date_2' => '05/04/2023'
            ];
        }
        return view('livewire.key-exhibits.credit-agreement', [
            'data' => $this->data
        ]);
    }
}
