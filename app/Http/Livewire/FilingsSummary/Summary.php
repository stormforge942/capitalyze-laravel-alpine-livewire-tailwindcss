<?php

namespace App\Http\Livewire\FilingsSummary;

use Livewire\Component;
use DB;

class Summary extends Component
{
    public $data = [];
    public $company;
    public $titles = [];
    public $financials = [];
    public $sortByDateTitle = [];
    public $search = [];

    public $col = "acceptance_time";
    public $order = "desc";

    public function mount(){
        foreach(getFilingsSummaryTab() as $item){
            $this->data[] = [
                'name' => $item['name'],
                'params' => $item['params'],
                'value' => $item['value'],
                'values' => $this->getDataFromDB($item['params'])->toArray()
            ];
        }
        $this->data = collect($this->data);
        // dd($this->data);
    }

    public function handleSorting($data){
        if ($this->col === $data[0]) {
            $this->order = $data[1] === 'asc' ? 'desc' : 'asc';
        } else {
            $this->order = 'asc';
        }
        $this->col = $data[0];
        $params = falingsSummaryTabFilteredValue($data[2])['params'];
        
        $financials = $this->getDataFromDB($params);
        $this->data = $this->data->map(function($item) use($data, $financials){
            if($item['value'] === $data[2]){
                $item['values'] = $financials->toArray();
            }
            return $item;
        });
        $sortByDateTitle = [];
        $sortByDateTitle[$data[2]] = $data[0];
        $this->sortByDateTitle = $sortByDateTitle;
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
        ->when($data, function($query, $data){
            return $query->whereIn('form_type', $data);
        })
        ->when($search, function($query) use($search) {
            return $query->where('form_type', 'like', "%$search%")
            ->orWhere('registrant_name', 'like', "%$search%");
        })
        ->orderBy($this->col, $this->order)
        ->get();
        return $query;
    }

    public function render()
    {
        // if($this->sortByDateTitle){
        //     dd($this->data);
        // }
        return view('livewire.filings-summary.summary');
    }

    public function handleViewAll($val){
        //$this->emit('handleAllFilingsTabs', $val);
        $this->emit('handleFilingsSummaryTab', ['all-filings', $val]);
        
    }
}
