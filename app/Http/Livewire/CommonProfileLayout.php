<?php

namespace App\Http\Livewire;
use Illuminate\Database\Eloquent\Model;
use App\Models\International;
use Livewire\Component;
use Request;

class CommonProfileLayout extends Component
{

    public $exchange;
    public Model $model;
    public $profile = false;
    public $path = [];

    public function viewProfile(){
        $this->profile = !$this->profile;
    }

    public function getURL(){
        $this->path = explode('/',Request::url());
        
        $interNationalExchange = ['lse','euronext','shanghai'];
        foreach($interNationalExchange as $ex){
            if(in_array($ex, $this->path))
                return true;
        }
        return false;
        
    }

    public function render()
    {
        $query = International::where('symbol',$this->model->symbol);
        
        // if($this->getURL()) {
        //     $query->where('exchange', 'London Stock Exchange');
        // }
        $data = $query->first();
        return view('livewire.common-profile-layout', [
            'internationProfile' => $this->getURL(),
            'data' => $data
        ]);
    }
}
