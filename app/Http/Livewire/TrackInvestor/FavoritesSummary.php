<?php

namespace App\Http\Livewire\TrackInvestor;

use Livewire\Component;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use App\Services\FundsSummaryGenerator;
use App\Services\MutualFundsSummaryGenerator;

class FavoritesSummary extends Component
{
    public $funds;
    public $mutualFunds;

    public $activeTab = 'funds';

    public $fundsSummary = null;
    public $mutualFundsSummary = null;

    private $data = [];

    private $tabs = ['funds' => '13F Filers', 'mutual-funds' => 'N-PORT Filers'];

    public function render()
    {
        return view('livewire.track-investor.favorites-summary', [
            'data' => $this->data,
            'tabs' => $this->tabs,
            'ranges' => [
                '3m' => '3m',
                '6m' => '6m',
                'ytd' => 'YTD',
                '1yr' => '1yr',
                '5yr' => '5yr',
                'max' => 'MAX',
            ],
        ]);
    }

    public function getData()
    {
        $this->activeTab = !in_array($this->activeTab, array_keys($this->tabs)) ? 'funds' : $this->activeTab;

        $fn = match ($this->activeTab) {
            'funds' => function () {
                if (!$this->fundsSummary) {
                    $key = 'fav-summary-f:' . Arr::join(array_keys($this->funds), ',');

                    $this->fundsSummary = Cache::rememberForever($key, fn() => app(FundsSummaryGenerator::class, ['funds' => $this->funds])->generate());
                }

                return $this->fundsSummary;
            },
            'mutual-funds' => function () {
                if (!$this->mutualFundsSummary) {
                    $key = 'fav-summary-mf:' . Arr::join(array_keys($this->mutualFunds), ',');

                    $this->mutualFundsSummary = Cache::rememberForever($key, fn() => app(MutualFundsSummaryGenerator::class, ['funds' => $this->mutualFunds])->generate());
                }

                return $this->mutualFundsSummary;
            },
        };

        $this->data = $fn();
    }
}
