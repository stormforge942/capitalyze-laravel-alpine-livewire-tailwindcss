<?php

namespace App\Http\Livewire\AllFilings;

use Livewire\Component;
use DB;

class Financials extends Component
{
    public $checkedCount;
    public $data = [];
    public $company;
    public $col = "acceptance_time";
    public $order = "desc";
    public $selectChecked = [];
    public $filtered;

    protected $listeners = ['emitCountInAllfilings', 'sortingOrder'];

    public function emitCountInAllfilings($selected){
        $count = json_decode($selected);
        $this->checkedCount = count($count ?? []);
        $this->selectChecked = $count ?? [];
        $this->data = $this->getDataFromDB($count);
    }

    public function sortingOrder($data){
        if ($this->col === $data[0]) {
            $this->order = $data[1] === 'asc' ? 'desc' : 'asc';
        } else {
            $this->order = 'asc';
        }
        $this->col = $data[0];
        $this->data = $this->getDataFromDB();
    }

    public function handleSearchAllDocuments($search){
        $this->data = $this->getDataFromDB(null, $search);
    }

    public function mount(){
        $filtered = falingsSummaryTabFilteredValue('financials')['params'];
        $this->filtered = $filtered;
        $this->data = $this->getDataFromDB($filtered);
    }

    public function getDataFromDB($selected=null, $search=null){
        $query = DB::connection('pgsql-xbrl')
        ->table('company_links')
        ->where('symbol', $this->company->ticker)
        // ->whereIn('form_type', $selected)
        ->when($selected, function($query, $filtered) {
            return $query->whereIn('form_type', $filtered); 
        })
        ->when($search, function($query, $search){
            return $query->where('form_type', 'like', "%$search%");
        })
        ->orderBy($this->col, $this->order)
        ->get();
        return $query;
    }


    public function render()
    {
        return view('livewire.all-filings.financials');
    }
}
