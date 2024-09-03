<?php

namespace App\Http\Livewire\InvestorFund;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use WireElements\Pro\Components\Modal\Modal;

class CompanyFundContent extends Modal
{
    public $data;

    public $company_name;
    public $ticker;
    public $newbuys;
    public $reduced;
    public $increased;
    public $tabs;
    public $price;

    public function mount($name, $data)
    {
        $this->company_name = $data['company_name'];
        $this->data = $data;
        $this->ticker = $data['ticker'];

        $this->price = $this->getEodPrice();

        $data = collect($data['funds']);
        $this->newbuys = $data->filter(function ($fund) {
            return $fund['change_amount'] > 0 && $fund['previous'] == 0;
        });
        $this->reduced = $data->filter(function ($fund) {
            return $fund['change_amount'] < 0;
        });
        $this->increased = $data->filter(function ($fund) {
            return $fund['change_amount'] > 0 && $fund['previous'] != 0;
        });

        $tabs = [[
            'title' => 'Summary',
            'icon' => null,
        ]];

        if ($this->newbuys->count() > 0) {
            $tabs[] = [
                'title' => 'New Buys',
                'icon' => 'blue',
            ];
        }
        if ($this->increased->count() > 0) {
            $tabs[] = [
                'title' => 'Increased',
                'icon' => 'green',
            ];
        }
        if ($this->reduced->count() > 0) {
            $tabs[] = [
                'title' => 'Reduced',
                'icon' => 'red',
            ];
        }

        $this->tabs = $tabs;
    }

    private function getEodPrice() {
        $cacheKey = 'eod_price-' . $this->ticker;

        $price = Cache::remember($cacheKey, Carbon::now()->addMinutes(5), function () {
            return DB::connection('pgsql-xbrl')
                ->table('eod_prices')
                ->select('close')
                ->where('symbol', strtolower($this->ticker))
                ->orderBy('date', 'desc')
                ->value('close') ?? 0;
        });

        return $price;
    }

    public function render()
    {
        return view('livewire.investor-fund.company-fund-content');
    }

    public static function attributes(): array
    {
        return [
            'size' => '6xl',
        ];
    }
}
