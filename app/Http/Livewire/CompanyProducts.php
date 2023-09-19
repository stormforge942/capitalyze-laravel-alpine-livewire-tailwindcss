<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;

class CompanyProducts extends Component
{
    public $company;

    public $ticker;

    public $period;

    public $products;

    public $segments;

    public $table;

    public $json;

    public $noData = false;

    public $isOpenedReportModal = false;

    protected $request;

    protected $listeners = ['periodChange'];

    public function getProducts()
    {
        $source = ($this->period == 'annual') ? 'arps' : 'qrps';
        $json = DB::connection('pgsql-xbrl')
            ->table('as_reported_sec_segmentation_api')
            ->where('ticker', '=', $this->ticker)
            ->where('endpoint', '=', $source)
            ->value('api_return_open_ai');

        $data = json_decode($json, true);
        $products = [];
        $dates = [];
        $segments = [];

        if ($json === null) {
            $this->noData = true;

            return;
        }

        foreach ($data as $date) {
            $key = array_key_first($date);
            $dates[] = $key;
            $products[$key] = $date[$key];
            $keys = array_keys($products[$key]);
            foreach ($keys as $subkey) {
                if (! in_array($subkey, $segments, true)) {
                    $segments[] = $subkey;
                }
            }
        }

        $this->json = base64_encode($json);
        $this->products = $products;
        $this->segments = $segments;
    }

//   public function renderTable() {
//        if($this->noData) {
//            return;
//        }
//        $i = 0;
//        $class = '';
//        $table = '<table class="table-auto min-w-full data"><thead><tr>';
//        $table .= '<th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900 bg-blue-300">Segment</th>';
//        foreach(array_keys($this->products) as $date) {
//            $table .= '<th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900 bg-blue-300">'.$date.'</th>';
//        }
//       $table .= '<th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900 bg-blue-300">' . 'Edit' . '</th>';
//        $table .= '</thead><tbody class="divide-y bg-white">';
//        foreach($this->segments as $segment) {
//            $class = ($i % 2 == 0) ? 'class="border border-slate-50 bg-cyan-50 hover:bg-blue-200"' : 'class="border border-slate-50 bg-white border-slate-100 hover:bg-blue-200"';
//            $table .= '<tr '.$class.'><td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">'.$segment.'</td>';
//            foreach(array_keys($this->products) as $date) {
//                if(array_key_exists($segment, $this->products[$date])) {
//                    $table .= '<td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">$'.number_format($this->products[$date][$segment],0).'</td>';
//                } else {
//                    $table .= '<td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900"></td>';
//                }
//            }
//            $table .= '<td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">'.
//                    '...'
//                .'</td>';
//            $table .= '</tr>';
//            $i++;
//        }
//        $table .= '</tbody></table>';
//
//        $this->table = $table;
//   }

    public function mount($company, $ticker, $period)
    {

        $this->company = $company;
        $this->ticker = $ticker;
        $this->period = $period;
        $this->getProducts();
//        $this->renderTable();
    }

    public function updateChart()
    {
        $this->emit('updateChart', $this->json, $this->period, $this->segments);
    }

    public function periodChange($period)
    {
        $this->period = $period;
        $this->getProducts();
//        $this->renderTable();

        $this->updateChart();
    }

    public function render()
    {
        return view('livewire.company-products');
    }
}
