<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CompanyLinksExport;
use DB;

class ComapanyFilingsSummary extends Component
{
    public $tabName = "summary";
    public $company;
    public $ticker;
    public $period;
    public $childTabName;
    public $loading = true;

    protected $listeners = ['handleFilingsSummaryTab' => 'setTabName', 'passTabNameInParent'];

    public function setTabName($tab){
        $this->loading = true;
        $selectedTab = is_array($tab) ? $tab[0] : $tab;
        $this->tabName = $selectedTab;
        if(is_array($tab)){
            $this->emit('handleAllFilingsTabs', $tab[1]);
        }
    }

    public function passTabNameInParent($tab){
        $this->childTabName = $tab;
        $this->loading = false;
    }

    public function downloadFile($file, $tabName){
        if(!$this->childTabName) {
            switch($tabName){
                case "all-filings": 
                    $childTabName = 'all-documents';
                    break;
                case "key-exhibits":
                    $childTabName = 'articles-inc-bylaws';
                    break;
                default: 
                    $childTabName = "";
                    break;
            }
        }
        else {
            $childTabName = $this->childTabName; 
        }
        $this->childTabName = $childTabName;
        $params = "";
        if($this->childTabName){
            if($tabName === "all-filings"){
                $params = falingsSummaryTabFilteredValue($this->childTabName)['params'];
                $data = $this->getDataFromDB($params);
            }
            else {
                $data = $this->getDataFromDB();
            }
            
        } 
        
        if($tabName === 'summary'){
            foreach(getFilingsSummaryTab() as $item){
                $data[] = [
                    "name" => $item['name'],
                    "values" => $this->getDataFromDB($item['params'])
                ];
            }
            $data = collect($data)->map(function($item, $key) {
                return $item['values'];
            })->collapse();
        }
        $tabName = $tabName === 'summary' ? 'summary' : $this->childTabName;
        if($file === 'pdf'){
            return $this->downLoadPdf($data, $tabName);
        }
        else if($file === 'csv'){
            return $this->downLoadCsv($data, $tabName);
        }
        else{
            return $this->downloadExcel($data, $tabName);
        }
        
    }

    public function getDataFromDB($selected=null){
        $query = DB::connection('pgsql-xbrl')
        ->table('company_links')
        ->where('symbol', $this->company->ticker)
        // ->whereIn('form_type', $selected)
        ->when($selected, function($query, $filtered) {
            return $query->whereIn('form_type', $filtered); 
        })
        ->get();
        return $query;
    }

    public function downloadExcel($data, $tabName){
        return Excel::download(new CompanyLinksExport($data->toArray()),$tabName. '.xlsx');
    }

    public function downLoadPdf($data, $tabName){
        $pdf = Pdf::loadView('filings-summary.pdf', compact('data'))->output();
        return response()->streamDownload(
            fn () => print($pdf),
            $tabName.".pdf"
        );
    }

    public function downLoadCsv($data, $tabName){
        return Excel::download(new CompanyLinksExport($data->toArray()),$tabName. '.csv', \Maatwebsite\Excel\Excel::CSV);
    }
    
    public function render()
    {
        return view('livewire.comapany-filings-summary');
    }
}
