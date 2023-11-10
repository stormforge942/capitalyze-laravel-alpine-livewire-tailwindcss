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
            ['name' => 'Financials'],
            ['name' => 'News'],
            ['name' => 'Registration and Prospectus'],
            ['name' => 'Proxy Materials'],
            ['name' => 'Ownership'],
            ['name' => 'Insider Equity'],
            ['name' => 'Others']
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

    public function handleViewAll(){
        $this->emit('handleFilingsSummaryTab', 'all-filings');
    }
}
