<?php

namespace App\Http\Livewire\FilingsSummary;

use Livewire\Component;

class Summary extends Component
{
    public $data = [];
    public $titles = [];

    public function render()
    {
        $this->titles = [
            [
                'name' => 'Financials',
                'value' => 'financials'
            ],
            [
                'name' => 'News',
                'value' => 'news'
            ],
            [
                'name' => 'Registration and Prospectus',
                'value' => 'registrations-and-prospectuses'
            ],
            [
                'name' => 'Proxy Materials',
                'value' => 'proxy-materials'
            ],
            [
                'name' => 'Ownership',
                'value' => 'ownership'
            ],
            [
                'name' => 'Insider Equity',
                'value' => 'insider-equity'
            ],
            [
                'name' => 'Others',
                'value' => 'other'
            ]
        ];
        for($i=0; $i<200; $i++){
            $this->data[] = [
                'name'=>'10-K',
                'desc' => 'Other event, financial statement and exhibits',
                'date_1' =>'05/04/2023', 
                'date_2' => '05/04/2023'
            ];
        }
        return view('livewire.filings-summary.summary', [
            'data'=>$this->data,
            'titles' => $this->titles
        ]);
    }

    public function handleViewAll($val){
        //$this->emit('handleAllFilingsTabs', $val);
        $this->emit('handleFilingsSummaryTab', ['all-filings', $val]);
        
    }
}
