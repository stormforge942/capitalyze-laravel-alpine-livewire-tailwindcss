<?php

namespace App\Http\Livewire\FilingsSummary;

use Livewire\Component;
use DB;

class Summary extends Component
{
    public $data = [];
    public $company;
    public $col = "acceptance_time";
    public $order = "desc";

    public function mount(){
        $data = $this->getDataFromDB();
        $filingsSummaryTab = getFilingsSummaryTab();

        $this->data = array_map(function ($item) use ($data) {
            $filteredValues = [];
            if (empty($item['params'])) {
                $filteredValues = $data->values()->all();
            } else {
                $filteredValues = $data->filter(function ($val) use ($item) {
                    return in_array($val->form_type, $item['params']);
                })->values()->all();
            }
        
            return [
                'name' => $item['name'],
                'params' => $item['params'],
                'value' => $item['value'],
                'values' => $filteredValues,
            ];
        }, $filingsSummaryTab);
    }

    public function handleSearch($data){
        $params = falingsSummaryTabFilteredValue($data[1])['params'];
        $financials = $this->getDataFromDB($params, $data[0]);
        $this->data = $this->data->map(function($item) use($data, $financials){
            if($item['value'] === $data[1]){
                $item['values'] = $financials->toArray();
            }
            return $item;
        });
        $search = [];
        $search[$data[1]] = $data[0];
        $this->search = $search;
    }

    public function getDataFromDB($data, $search=null){
        $query = DB::connection('pgsql-xbrl')
        ->table('company_links')
        ->where('symbol', $this->company->ticker)
        ->orderBy($this->col, $this->order)
        ->get();
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
