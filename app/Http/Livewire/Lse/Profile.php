<?php

namespace App\Http\Livewire\Lse;

use App\Http\Livewire\BaseProfileComponent;
use Illuminate\Database\Eloquent\Model;
use App\Models\LseProfile;
use Request;

class Profile extends BaseProfileComponent
{
    public $exchange;
    public Model $model;
    public $profile = false;

    public function viewProfile(){
        $this->profile = !$this->profile;
    }

    public function getURL(){
        $path = explode('/',Request::url());
        $interNationalExchange = ['lse','euronext','shanghai'];
        foreach($interNationalExchange as $exchange){
            if(in_array($exchange, $path))
                return true;
            else return false;
        }
        
    }

    public function title(): string
    {
        return "LSE Profile - {$this->model->registrant_name} ({$this->model->symbol})";
    }

    public function render(){
        $query = LseProfile::where('symbol',$this->model->symbol);
        if($this->getURL()) {
            $query->where('exchange', 'London Stock Exchange');
        }
        $query->first();
        return view('livewire.lse-profile', [
            'lse' => $this->getURL(),
            'data' => LseProfile::where('symbol',$this->model->symbol)->first()
        ]);
    }
}
