<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class CompanyProducts extends Component
{
    public $company;
    public $ticker;
    public $period;
    public $products;
    public $segments;
    public $table;
    protected $request;

   protected $listeners = ['periodChange'];

   public function getProducts() {
        $source = ($this->period == 'annual') ? 'as_reported_sec_quarter_revenue_product_segmentation_api' : 'as_reported_sec_annual_revenue_product_segmentation_api';
        $data = DB::connection('pgsql-xbrl')
        ->table($source)
        ->where('ticker', '=', $this->ticker)
        ->value('api_return_simplified_new');

        $data = json_decode($data, true);
        $products = [];
        $dates = [];
        $segments = [];

        foreach($data as $date) {
            $key = array_key_first($date);
            $dates[] = $key;
            $products[$key] = $date[$key];
            $keys = array_keys($products[$key]);
            foreach($keys as $subkey) {
                if(!in_array($subkey, $segments, true)){
                    $segments[] =  $subkey;
                }
            }
        }
        
        $this->products = $products;
        $this->segments = $segments;
   }

   public function renderTable() {
        $i = 0;
        $class = '';
        $table = '<table class="table-auto min-w-full data"><thead><tr>';
        $table .= '<th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900 bg-cyan-200">Segment</th>';
        foreach(array_keys($this->products) as $date) {
            $table .= '<th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900 bg-cyan-200">'.$date.'</th>';
        }
        $table .= '</thead><tbody class="divide-y bg-white">';
        foreach($this->segments as $segment) {
            $class = ($i % 2 == 0) ? 'class="border border-slate-50 bg-cyan-50 hover:bg-blue-200 dark:bg-slate-700 dark:odd:bg-slate-800 dark:odd:hover:bg-slate-900 dark:hover:bg-slate-700"' : 'class="border border-slate-50 bg-white border-slate-100 dark:border-slate-400 hover:bg-blue-200 dark:bg-slate-700 dark:odd:bg-slate-800 dark:odd:hover:bg-slate-900 dark:hover:bg-slate-700"';
            $table .= '<tr '.$class.'><td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">'.$segment.'</td>';
            foreach(array_keys($this->products) as $date) {
                if(array_key_exists($segment, $this->products[$date])) {
                    $table .= '<td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">$'.number_format($this->products[$date][$segment],0).'</td>';
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
        $this->getProducts();
        $this->renderTable();
    }

    public function periodChange($period) {
        $this->period = $period;
        $this->getProducts();
        $this->renderTable();
    }

    public function render()
    {
        return view('livewire.company-products');
    }
}
