<?php

namespace App\Http\Livewire\InvestorFund;

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

    public function mount($name, $data)
    {
        $this->company_name = $data['company_name'];
        $this->data = $data;
        $this->ticker = $data['ticker'];

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
