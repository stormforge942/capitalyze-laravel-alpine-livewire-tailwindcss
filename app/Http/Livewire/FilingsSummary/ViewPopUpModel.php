<?php

namespace App\Http\Livewire\FilingsSummary;

use Livewire\Component;
use Request;
use DB;
use Barryvdh\DomPDF\Facade\Pdf; 

class ViewPopUpModel extends Component
{
    public $s3_link;
    public $form_type;
    public $countRows;
    public $company;
    public $index;
    public $transForm = 0;
    public $rows = [];
    public $row  = [];
    public $scale = 100;

    protected $listeners = ['passDataInViewPopModel'];

    public function handleFormType(){
        $row = collect($this->rows)->where('form_type', $this->form_type)->first();
        $this->s3_link = $this->getTheS3LinkViaCurl($row->s3_link ?? $row['link']);
        $this->index = $this->getIndexOfArray($this->rows, $row);
    }

    public function handleZoomInOrZoomOut($value){
        $numbers = [0, 50, 75,90, 95, 100,105, 110, 125, 150];
        $index = array_search($this->scale, $numbers);
        if($index > 0 && $index < 9){
            if($value === 'increament'){
                $difference = $numbers[$index + 1] - $this->scale;
                $this->scale += $difference;
            }
            else if($value === 'decreament'){
                $difference = $this->scale - $numbers[$index - 1] ;
                $this->scale -= $difference;
            }
        }
        else {
            $this->scale = 100;
        }
    }

    public function handleTransform(){
        switch($this->transForm){
            case 90:
                $this->transForm = 180;
                break;
            case 180: 
                $this->transForm = 270;
                break;
            case 270: 
                $this->transForm = 0;
                break;
            case 0: 
                $this->transForm = 90;
                break;
            default :
                $this->transForm = 0;
                break;
        }
    }

    public function passDataInViewPopModel($row){
        $d = json_decode($row[0]);
        $params = json_decode($row[1]);
        $this->form_type = $d->form_type;
        $url = $d->final_link ?? $d->link;
        $this->s3_link = $this->getTheS3LinkViaCurl($url);
        $this->rows = $this->getDataFromDB($params);
        $index = $this->getIndexOfArray($this->rows, $d);
        $this->index = $index;
    }

    public function getTheS3LinkViaCurl($url){
        $agent = Request::header('user-agent');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_USERAGENT, $agent);
        $html = curl_exec($ch);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public function getDataFromDB($params, $search=null){
        $query = DB::connection('pgsql-xbrl')
        ->table('company_links')
        ->where('symbol', $this->company->ticker)
        ->when($params, function($query, $params){
            return $query->whereIn('form_type', $params);
        })
        ->orderBy('acceptance_time', 'desc')
        ->get();
        return $query;
    }

    public function closePopUp(){
        $this->rows = [];
        $this->s3_link = '';
        $this->index = 0;
        $this->form_type="";
    }

    public function handleNexPage($index) {
        if($index < 0) {
            $this->index = 0;
            return ;
        }
        if($index === count($this->rows)){
            $this->index = count($this->rows);
            return ;
        }
        
        $row = $this->rows[$index];
        $this->s3_link = $this->getTheS3LinkViaCurl($row->final_link ?? $row['final_link']);
        $this->form_type = $row->form_type ?? $row['form_type'];
        $this->index = $index;
    }

    public function getIndexOfArray($rows, $d){
        $index = collect($rows)->search(function($item) use($d) {
            return ($item->form_type ?? $item['form_type']) === ($d->form_type ?? $d['form_type']);
        });
        return $index;
    }

    public function render()
    {
        return view('livewire.filings-summary.view-pop-up-model');
    }
}
