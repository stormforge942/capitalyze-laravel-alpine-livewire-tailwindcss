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
        $this->s3_link = $this->getTheS3LinkViaCurl($row->final_link ?? $row['final_link']);
    }

    public function passDataInViewPopModel($row){
        $d = json_decode($row[0]);
        $params = json_decode($row[1]);
        $this->form_type = $d->form_type;
        $url = $d->final_link ?? $d->link;
        $this->s3_link = $this->getTheS3LinkViaCurl($url);
        $this->rows = $this->getDataFromDB($params);
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

    public function render()
    {
        return view('livewire.filings-summary.view-pop-up-model');
    }
}
