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
    public $navbar;
    public $subnavbar;
    public $activeIndex = 'face';
    public $activeSubIndex = 'Incomestatement';
    public $table;
    public $faces;
    protected $request;

   protected $listeners = ['periodChange', 'metricChange', 'tabClicked', 'tabSubClicked'];

   public function getMetrics() {
    $source = ($this->period == 'annual') ? 'as_reported_sec_annual_restated_api' : 'as_reported_sec_quarter_restated_api';
    $data = DB::connection('pgsql-xbrl')
    ->table($source)
    ->where('ticker', '=', $this->ticker)
    ->value('api_return_with_unit');

    $data = json_decode($data, true);
    $metrics = [];
    $dates = [];
    $segments = [];

    // Parse the actual face from activeSubIndex
    $currentFace = substr($this->activeSubIndex, strpos($this->activeSubIndex, "-") + 1);

    foreach($data as $date) {
        $key = array_key_first($date);
        $dates[] = $key;
        if(array_key_exists($this->activeIndex, $date[$key])) {
            if(array_key_exists($currentFace, $date[$key][$this->activeIndex])) {
                $metrics[$key] = $date[$key][$this->activeIndex][$currentFace];
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


   public function getNavbar() {
    $source = ($this->period == 'annual') ? 'as_reported_sec_annual_restated_api' : 'as_reported_sec_quarter_restated_api';
    $data = DB::connection('pgsql-xbrl')
    ->table($source)
    ->where('ticker', '=', $this->ticker)
    ->value('api_return_with_unit');

    $data = json_decode($data, true);
    $first_data = $data[0][key($data[0])];
    $groups = [];
    $navbar = [];

    foreach($first_data as $key => $group) {
        $groups[$key] = array_keys($group);
    }

    foreach($groups as $key => $face) {
        foreach($face as $value) {
            $id = $key . "-" . $value; // generating a pseudo-unique ID
            $navbar[$key][] = ['value' => $value, 'id' => $id, 'title' => $value, 'selected' => ($value == $this->activeSubIndex)];
        }
    }

    $this->activeIndex = array_keys($navbar)[0];  // or any other logic to determine the active index
    $this->activeSubIndex = 'face-Incomestatement';  // or any other logic to determine the active sub index
    $this->navbar = $navbar;
    $this->emit('navbarUpdated', $this->navbar, $this->activeIndex, $this->activeSubIndex);
    }

   public function renderTable() {
        $i = 0;
        $class = '';
        $table = '<table class="table-auto min-w-full data border-collapse"><thead><tr>';
        $table .= '<th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900 bg-blue-300">Date</th>';
        foreach(array_keys($this->metrics) as $date) {
            $table .= '<th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-slate-950 bg-blue-300">'.$date.'</th>';
        }
        $table .= '</thead><tbody class="divide-y bg-white">';
        foreach($this->segments as $segment) {
            $class = ($i % 2 == 0) ? 'class="border border-slate-50 bg-cyan-50 hover:bg-blue-200 dark:bg-slate-700 dark:odd:bg-slate-800 dark:odd:hover:bg-slate-900 dark:hover:bg-slate-700"' : 'class="border border-slate-50 bg-white border-slate-100 dark:border-slate-400 hover:bg-blue-200 dark:bg-slate-700 dark:odd:bg-slate-800 dark:odd:hover:bg-slate-900 dark:hover:bg-slate-700"';
            $table .= '<tr '.$class.'><td class="break-words max-w-[150px] lg:max-w-[400px] px-2 py-2 text-sm text-gray-900 font-bold">'.preg_replace('/(?<=\w)(?=[A-Z])/', ' ', $segment).'</td>';
            foreach(array_keys($this->metrics) as $date) {
                if(array_key_exists($segment, $this->metrics[$date])) {
                    if($this->metrics[$date][$segment][1] == 'USD')
                        $value = number_format(floatval($this->metrics[$date][$segment][0]),0).' $';                
                    else
                        $value = $this->metrics[$date][$segment][0];
                    $data = array("hash" => $this->metrics[$date][$segment][2], "ticker" => $this->ticker, "period" => $date);
                    $data_json = json_encode($data);
                    $table .= '<td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900 hover:cursor-pointer hover:underline underline-offset-1 open-slide" data-value="'.htmlspecialchars($data_json).'">'.$value.'</td>';
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
        $this->getNavbar();
        $this->getMetrics();
        $this->renderTable();
    }

    public function metricChange($face, $parent)
    {
        $this->activeIndex = $parent;
        $this->activeSubIndex = $face;
        
        $this->getMetrics();
        $this->renderTable();
    }

    public function periodChange($period) {
        $this->period = $period;
        $this->getMetrics();
        $this->getNavbar();
        $this->renderTable();
    }
    

    public function tabClicked($key) {
        $this->activeIndex = $key;
        $this->getMetrics();
        $this->renderTable();
    }

    public function tabSubClicked($key) {
        $this->activeSubIndex = $key;
        $this->getMetrics();
        $this->renderTable();
    }
    public function render()
    {
        return view('livewire.company-metrics');
    }
}
