<?php

namespace App\Http\Livewire\Discover;

use Livewire\Component;

class Fund extends Component
{
    public $loading = false;
    protected $listeners = ['loadingFire' => 'handleLoadingFire'];

    public  function handleLoadingFire(){
        $this->loading = true;
    }

    public function render()
    {
        $data = [
            'title' => 'Berkshire Hathaway',
            'items' => [
                [
                    'label' => 'Market Value',
                    'value' => '$2.78T'
                ],
                [
                    'label' => 'Holdings',
                    'value' => '1,500'
                ],
                [
                    'label' => 'CEO',
                    'value' => 'Warren Buffet'
                ],
                [
                    'label' => 'Turnover',
                    'value' => '$133.74B'
                ]
            ]
        ];
        $discover = [];
        for($i=0; $i<100; $i++){
            $discover[] = $data;
        }
        $this->loading = true;
        return view('livewire.discover.fund', [
            'discover' => $discover
        ]);
    }
}
