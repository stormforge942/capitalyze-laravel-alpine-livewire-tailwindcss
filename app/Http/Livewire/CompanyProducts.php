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

    public function mount($company, $ticker, $period)
    {
        $this->company = $company;
        $this->ticker = $ticker;
        $this->period = $period;
        $this->getProducts();
    }

    public function updateChart()
    {
        $this->emit('updateChart', $this->json, $this->period, $this->segments);
    }

    public function periodChange($period)
    {
        $this->period = $period;
        $this->getProducts();

        $this->updateChart();
    }

    public function render()
    {
        return view('livewire.company-products');
    }
}
