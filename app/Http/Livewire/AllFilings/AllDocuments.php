<?php

namespace App\Http\Livewire\AllFilings;
use App\Models\CompanyLinks;
use Livewire\Component;
use DB;

class AllDocuments extends Component
{
    public $checkedCount;
    public $data = [];
    public $col = "acceptance_time";
    public $order = "desc";
    public $selectChecked = [];

    protected $listeners = ['emitCountInAllfilings', 'sortingOrder'];

    public function emitCountInAllfilings($selected){
        $this->checkedCount = count($selected ?? []);
        $this->selectChecked = $selected ?? [];
        $this->data = $this->getDataFromDB($selected);
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
        $this->data = $this->getDataFromDB();
    }

    public function getDataFromDB($selected=null, $search=null){
        $query = DB::connection('pgsql-xbrl')
        ->table('company_links')
        ->where('symbol', 'AAPL')
        // ->whereIn('form_type', $selected)
        ->when($selected, function($query, $selected) {
            return $query->whereIn('form_type', $selected); 
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
        return view('livewire.all-filings.all-documents');
    }
}
