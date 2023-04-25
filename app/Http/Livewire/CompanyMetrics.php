<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class CompanyMetrics extends Component
{
    public $company;
    public $ticker;
    public $period;
    public $metrics;
    public $segments;
    public $table;
    public $faces;
    public $parentFace = 'face';
    public $currentFace = 'Incomestatement';
    protected $request;

   protected $listeners = ['periodChange', 'metricChange'];

   public function getMetrics() {
        $source = ($this->period == 'annual') ? 'as_reported_sec_annual_restated_api' : 'as_reported_sec_quarter_restated_api';
        $data = DB::connection('pgsql-xbrl')
        ->table($source)
        ->where('ticker', '=', $this->ticker)
        ->value('api_return');

        $data = json_decode($data, true);
        $metrics = [];
        $dates = [];
        $segments = [];

        foreach($data as $date) {
            $key = array_key_first($date);
            $dates[] = $key;
            if(array_key_exists($this->parentFace, $date[$key])) {
                if(array_key_exists($this->currentFace, $date[$key][$this->parentFace])) {
                    $metrics[$key] = $date[$key][$this->parentFace][$this->currentFace];
                    $keys = array_keys($metrics[$key]);
                    foreach($keys as $subkey) {
                        if(!in_array($subkey, $segments, true)){
                            $segments[] =  $subkey;
                        }
                    }
                }
            }
        }
        
        $this->metrics = $metrics;
        $this->segments = $segments;
   }

   public function renderFaces() {
        $source = ($this->period == 'annual') ? 'as_reported_sec_annual_restated_api' : 'as_reported_sec_quarter_restated_api';
        $data = DB::connection('pgsql-xbrl')
        ->table($source)
        ->where('ticker', '=', $this->ticker)
        ->value('api_return');

        $data = json_decode($data, true);
        $first_data = $data[0][key($data[0])];
        $groups = [];
        $dropdown = '';

        foreach($first_data as $key => $group) {
            $groups[$key] = array_keys($group);
        }

        foreach($groups as $key => $face) {
            $dropdown .= '<optgroup label="'.$key.'">';
            foreach($face as $value) {
                if($value == $this->currentFace)
                    $dropdown .= '<option value="'.$value.'" selected>'.$value.'</option>';
                else
                    $dropdown .= '<option value="'.$value.'">'.$value.'</option>';
            }
            $dropdown .= '</optgroup>';
        }
        

        $this->faces = $dropdown;
   }

   public function renderTable() {
        $i = 0;
        $class = '';
        $table = '<table class="table-auto min-w-full data"><thead><tr>';
        $table .= '<th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900 bg-cyan-200">Segment</th>';
        foreach(array_keys($this->metrics) as $date) {
            $table .= '<th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900 bg-cyan-200">'.$date.'</th>';
        }
        $table .= '</thead><tbody class="divide-y bg-white">';
        foreach($this->segments as $segment) {
            $class = ($i % 2 == 0) ? 'class="border border-slate-50 bg-cyan-50 hover:bg-blue-200 dark:bg-slate-700 dark:odd:bg-slate-800 dark:odd:hover:bg-slate-900 dark:hover:bg-slate-700"' : 'class="border border-slate-50 bg-white border-slate-100 dark:border-slate-400 hover:bg-blue-200 dark:bg-slate-700 dark:odd:bg-slate-800 dark:odd:hover:bg-slate-900 dark:hover:bg-slate-700"';
            $table .= '<tr '.$class.'><td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900 font-bold">'.preg_replace('/(?<=\w)(?=[A-Z])/', ' ', $segment).'</td>';
            foreach(array_keys($this->metrics) as $date) {
                if(array_key_exists($segment, $this->metrics[$date])) {
                    $table .= '<td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">'.$this->metrics[$date][$segment].'</td>';
                } else {
                    $table .= '<td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900"></td>';
                }
            }
            $table .= '</tr>';
            $i++;
        }
        $table .= '</tbody></table>';

        $this->table = $table;
   }

    public function mount($company, $ticker, $period)
    {

        $this->company  = $company;
        $this->ticker = $ticker;
        $this->period = $period;
        $this->renderFaces();
        $this->getMetrics();
        $this->renderTable();
    }

    public function metricChange($face, $parent)
    {
        $this->parentFace = $parent;
        $this->currentFace = $face;

        $this->renderFaces();
        $this->getMetrics();
        $this->renderTable();
    }

    public function periodChange($period) {
        $this->period = $period;
        $this->getMetrics();
        $this->renderTable();
    }

    public function render()
    {
        return view('livewire.company-metrics');
    }
}
