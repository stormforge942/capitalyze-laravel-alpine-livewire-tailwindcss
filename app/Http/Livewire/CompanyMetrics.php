<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class CompanyMetrics extends Component
{
    use TableFiltersTrait;
    public $company;
    public $ticker;
    public $currentRoute;
    public $period;
    public $metrics;
    public $segments;

    public $navbar;
    public $subnavbar;
    public $activeIndex = 'face';
    public $activeSubIndex = 'Balancesheet';
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
    $this->activeSubIndex = 'face-Balance Sheet';  // or any other logic to determine the active sub index
    $this->navbar = $navbar;
    $this->emit('navbarUpdated', $this->navbar, $this->activeIndex, $this->activeSubIndex);
    }

   public function renderTable() {
            $table = '';
            //collect rows
            $table .= '<div class="row row-spoiler">';//spoiler control row outside of group
                $table .= '<div class="cell" >Spoiler test</div>';
                $table .= str_repeat('<div class="cell" >-</div>', count($this->metrics) );
            $table .= '</div>';
            $table .= '<div class="row-group row-group-spoiler">'; //row group spoiler
            foreach($this->segments as $segment) {
                $table .= '<div class="row">';
                    $table .= '<div class="cell break-words font-bold">&nbsp; '.preg_replace('/(?<=\w)(?=[A-Z])/', ' ', $segment).'</div>';
                    foreach(array_keys($this->metrics) as $date) {
                        if(array_key_exists($segment, $this->metrics[$date])) {
                            if($this->metrics[$date][$segment][1] == 'USD')
                                //$value = number_format(floatval($this->metrics[$date][$segment][0]),0).' $';
                                $value = $this->formatWithUnitType($this->metrics[$date][$segment][0]);
                            else
                                $value = $this->metrics[$date][$segment][0];
                            $data = array("hash" => $this->metrics[$date][$segment][2], "ticker" => $this->ticker, "period" => $date);
                            $data_json = json_encode($data);
                             $table .= '<div class="cell whitespace-nowrap hover:cursor-pointer hover:underline underline-offset-1 open-slide" data-value="'.htmlspecialchars($data_json).'">'.$value.'</div>';
                        } else {
                            $table .= '<div class="cell whitespace-nowrap cell"></div>';
                        }
                    }
                $table .= '</div>'; // .row
            }
            $table .= '</div>'; // test row group

        $this->table = $table;
   }

    public function mount($company, $ticker, $period)
    {
        $this->company  = $company;
        $this->ticker = $ticker;
        $this->currentRoute = request()->route()->getName();
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
