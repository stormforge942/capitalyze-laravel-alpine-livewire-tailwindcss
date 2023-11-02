<?php

namespace App\Http\Livewire\TrackInvestor;

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
        $investors = [];
        for($i=0; $i<100; $i++){
            $investors[] = $data;
        }
        $this->loading = true;
        return view('livewire.track-investor.fund', [
            'investors' => $investors
        ]);
    }
}
