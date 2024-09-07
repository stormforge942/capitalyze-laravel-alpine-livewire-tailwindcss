<?php

namespace App\Http\Livewire\InvestorFund;

use Livewire\Component;

class PurchaseContinuumGraph extends Component
{
    public $chartData;
    public $data;
    public $price;
    public $companyName;

    public function mount($data, $price)
    {
        $this->data = $data;
        $this->companyName = $data['company_name'];
        $this->price = $price;
    }

    public function load()
    {
        $priceData = [];
        $funds = collect($this->data['funds']);

        $funds->each(function ($fund) use (&$priceData) {
            $name = '';
            if (array_key_exists('fund_symbol', $fund) && $fund['fund_symbol'])
                $name = $fund['name'] . '(' . $fund['fund_symbol'] . ')';
            else
                $name = $fund['name'];

            $priceData[$name] = [
                'price' => $fund['price'], 
                'date' => $fund['date']
            ];
        });

        $this->chartData = $priceData;
    }

    public function render()
    {
        return view('livewire.investor-fund.purchase-continuum-graph');
    }
}
