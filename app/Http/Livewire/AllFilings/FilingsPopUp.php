<?php

namespace App\Http\Livewire\AllFilings;
use App\Models\CompanyLinks;
use Livewire\Component;
use Cache;

class FilingsPopUp extends Component
{
    public $model = false;
    public $selectedIds = [];
    public $selectedTab = "D-9";
    public $formTypes = [
        'D-9', 'A-G', 'H-N', 'O-Q', 'Q-W', 'X-Z'
    ];

    protected $listeners = ['handleFilingBrowserType'];

    public function handleFilingBrowserType($val){
        $this->model = $val;
    }

    public function getDataFromDB(){
        $data = CompanyLinks::where('symbol', 'AAPL')
        ->select('form_type')
        ->distinct()
        ->pluck('form_type');
        Cache::put('form_type_data', $data, 15);
        return $data;
    }

    public function handleFormTypeTabs($tab){
        $this->selectedIds = [];
        $this->selectedTab = $tab;
    }

    public function handleCheckBox(){
      $this->emit('emitCountInAllfilings', $this->selectedIds);  
    }

    public function render()
    {
        if(Cache::has('form_type_data')){
            $data = Cache::get('form_type_data');
        }
        else {
            $data = $this->getDataFromDB();
        }

        $dta = []; 
        $range = explode('-', $this->selectedTab);
        $startRange = $range[0];
        $endRange = $range[1];

        foreach ($data as $item) {
            if($this->selectedTab === 'D-9') {
                if (preg_match('/\d/', $item)) {
                    $dta[] = $item;
                }
            }
            else {
                $wordParts = explode('-', $item);
                $firstPart = $wordParts[0];
                $lastPart = end($wordParts);
                $firstChar = $firstPart[0];
                $lastChar = $lastPart[strlen($lastPart) - 1];
                if ($startRange <= $firstChar && $lastChar <= $endRange) {
                    $dta[] = $item;
                }
            }
        }
        
        return view('livewire.all-filings.filings-pop-up', [
            'data' => $dta,
            'formTypes' => $this->formTypes,
        ]);
    }
}
