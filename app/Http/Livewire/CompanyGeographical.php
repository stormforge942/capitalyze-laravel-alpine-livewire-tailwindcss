<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class CompanyGeographical extends Component
{
    use TableFiltersTrait;
    
    public $company;
    public $ticker;
    public $period;
    public $geographical;
    public $segments;
    public $table;
    public $json;
    public $currentRoute;

    public $segmentationTab = 'product';


    public $noData = false;
    protected $request;

   protected $listeners = ['periodChange'];

   public function getGeographical() {
        $source = ($this->period == 'annual') ? 'args' : 'qrgs';
        $json = DB::connection('pgsql-xbrl')
        ->table('as_reported_sec_segmentation_api')
        ->where('ticker', '=', $this->ticker)
        ->where('endpoint', '=', $source)
        ->value('api_return_open_ai');

        $data = json_decode($json, true);
        $geographical = [];
        $dates = [];
        $segments = [];

        if ($json === null) {
            $this->noData = true;
            return;
        }

        foreach($data as $date) {
            $key = array_key_first($date);
            $dates[] = $key;
            $geographical[$key] = $date[$key];
            $keys = array_keys($geographical[$key]);
            foreach($keys as $subkey) {
                if(!in_array($subkey, $segments, true)){
                    $segments[] =  $subkey;
                }
            }
        }

        $this->json = base64_encode($json);
        $this->geographical = $geographical;
        $this->segments = $segments;
   }

   public function renderTable() {
        if($this->noData) {
            return;
        }
        $i = 0;
        $table = '<div class="table">';
            $table .= '<div class="row row-head">';
                $table .= '<div class="cell">Segment</div>';
                foreach(array_keys($this->geographical) as $date) {
                    $table .= '<div class="cell">'.$date.'</div>';
                }
            $table .= '</div>';

        foreach($this->segments as $segment) {
            $table .= '<div class="row">';
                $table .= '<div class="cell text-gray-900">'.$segment.'</div>';
                foreach(array_keys($this->geographical) as $date) {
                    if(array_key_exists($segment, $this->geographical[$date])) {
                        $table .= '<div class="cell">$'.number_format($this->geographical[$date][$segment],0).'</div>';
                    } else {
                        $table .= '<div class="cell"></div>';
                    }
                }
            $table .= '</div>'; //row
            $i++;
        }
        $table .= '</div>'; // </table>

        $this->table = $table;
   }

    public function mount($company, $ticker, $period)
    {
        $this->currentRoute = request()->route()->getName();
        $this->company  = $company;
        $this->ticker = $ticker;
        $this->period = $period;
        $this->getGeographical();
        $this->renderTable();
    }

    public function periodChange($period) {
        $this->period = $period;
        $this->getGeographical();
        $this->renderTable();

        $this->emit('updateChart', $this->json, $this->period, $this->segments);
    }

    public function render()
    {
        return view('livewire.company-geographical');
    }
}
