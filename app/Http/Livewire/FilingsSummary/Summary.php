<?php

namespace App\Http\Livewire\FilingsSummary;

use Livewire\Component;
use DB;
use Illuminate\Support\Facades\Cache;

class Summary extends Component
{
    public $data = [];
    public $company;
    public $col = "acceptance_time";
    public $order = "desc";
    public $values = [];
    public $items;

    public function mount(){
        $data = $this->getDataFromDB();
        $this->values = $data;
        $this->items = getFilingsSummaryTab();
    }

    public function getDataFromDB(){

        $cacheKey = 'company_links_' . $this->company->ticker . '_' . $this->col . '_' . $this->order;
        $cacheDuration = 3600;

        $query = Cache::remember($cacheKey, $cacheDuration, function () {
            return DB::connection('pgsql-xbrl')
                ->table('company_links')
                ->where('symbol', $this->company->ticker)
                ->whereRaw("SUBSTRING(acceptance_time, 1, 4)::integer > 2018")
                ->orderBy($this->col, $this->order)
                ->get();
        });
        
        return $query;
    }

    public function render()
    {
        return view('livewire.filings-summary.summary');
    }

    public function handleViewAll($val){
        $this->emit('handleFilingsSummaryTab', ['all-filings', $val]);        
    }
}
