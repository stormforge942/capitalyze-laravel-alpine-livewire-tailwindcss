<?php

namespace App\Http\Livewire\TrackInvestor;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class FavoritesSummary extends Component
{
    public $funds;
    public $mutualFunds;

    public function render()
    {
        dump($this->getTopBuys());
        return view('livewire.track-investor.favorites-summary', [
            'topBuys' => $this->getTopBuys(),
        ]);
    }

    public function getTopBuys()
    {
        return array_values(DB::connection('pgsql-xbrl')
            ->table('filings')
            ->select(DB::raw("MAX(change_in_shares_percentage) as buy_change"),  DB::raw('MIN(change_in_shares_percentage) as sell_change'), 'symbol', 'name_of_issuer', 'cik')
            ->whereIn('cik', array_keys($this->funds))
            ->where('report_calendar_or_quarter', '=', '2023-12-31')
            ->groupBy('symbol', 'name_of_issuer', 'cik') // To get unique symbols
            ->limit(10)
            ->get()
            ->map(function ($item) {
                $item->fund_name = $this->funds[$item->cik];
                $item->name_of_issuer = Str::title($item->name_of_issuer);
                $item->formatted_buy_change = round($item->buy_change, 3) . '%';
                $item->formatted_sell_change = round($item->sell_change, 3) . '%';
                return $item;
            })
            ->groupBy('cik')
            ->toArray());
    }
}
