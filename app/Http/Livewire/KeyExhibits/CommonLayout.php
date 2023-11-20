<?php

namespace App\Http\Livewire\KeyExhibits;

use Livewire\Component;

class CommonLayout extends Component
{
    public $data = [];
    
    // public function mount(){
    //     $this->data = CompanyLinks::where('symbol', 'AAPL')
    //     ->orderByDesc('acceptance_time')
    //     ->get();
    // }
    public function render()
    {
        $data = CompanyLinks::where('symbol', 'AAPL')
        ->orderByDesc('acceptance_time')
        ->get();
        dd($data);
        return view('livewire.key-exhibits.common-layout', [
            'data' => $data
        ]);
    }
}
