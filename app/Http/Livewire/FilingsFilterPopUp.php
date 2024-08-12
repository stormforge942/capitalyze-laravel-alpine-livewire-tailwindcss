<?php

namespace App\Http\Livewire;
use App\Models\CompanyLinks;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class FilingsFilterPopUp extends Component
{
    public $model = false;
    public $type = 'filing';
    public $selectedIds = [];
    public $selectedTab = "0-9";
    public $search;
    public $sortBy = "form_type";
    public $selectChecked;
    public $sortOrder;
    public $formTypes = [
        '0-9', 'A-G', 'H-N', 'O-Q', 'Q-W', 'X-Z'
    ];

    protected $listeners = ['handleFilingBrowserType', 'setSortOrder'];

    public function handleFilingBrowserType($val){
        $this->model = $val;
    }

    public function mount()
    {
        $this->handleFormTypeTabs($this->selectedTab);
    }

    public function handleSearch($val)
    {
        $this->data = $this->getDataFromDB($val);
    }

    public function setSortOrder($val)
    {
        $this->sortOrder = $val;
    }

    public function getDataFromDB($search = null)
    {
        return Cache::remember('form_type_data', 15, function () use ($search) {
            return CompanyLinks::where('symbol', 'AAPL')
                ->select('form_type')
                ->distinct()
                ->when($search, function($query) use ($search) {
                    return $query->where('form_type','like', "%$search%");
                })
                ->pluck('form_type');
        });
    }

    public function handleChange()
    {
        $this->getDataFromDB();
    }

    public function handleFormTypeTabs($tab)
    {
        $this->data = Cache::has('form_type_data') ? Cache::get('form_type_data') : $this->getDataFromDB();
        $this->selectedIds = [];
        $this->selectedTab = $tab;
    }

    public function render()
    {
        return view('livewire.filings-filter-pop-up');
    }
}
