<?php

namespace App\Http\Livewire\Ownership;

use Livewire\Component;
use App\Services\OwnershipHistoryService;
use App\Models\TrackInvestorFavorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\MutualFunds;

class MutualFund extends Component
{
    public $company;
    public $fund;
    public $fundSymbol;
    public $isFavourite;
    
    public $tabs = [
        MutualFundSummary::class,
        MutualFundHoldings::class,
    ];

    public function mount($fund, $company = null)
    {
        $this->fund = $fund;
        $this->fundSymbol = $fund->fund_symbol;
        $this->company = $company;

        $this->checkFavourite();

        OwnershipHistoryService::push([
            'name' => $this->fund->registrant_name,
            'url' => request()->url(),
        ]);
    }

    public function checkFavourite()
    {
        $entry = TrackInvestorFavorite::query()
            ->where('identifier', $this->fund->fund_symbol)
            ->where('type', TrackInvestorFavorite::TYPE_MUTUAL_FUND)
            ->where('user_id', Auth::id())
            ->get();

        $this->isFavourite = $entry->count() ? true : false;
    }

    public function hydrate()
    {
        $this->fund = MutualFunds::query()->where('fund_symbol', $this->fundSymbol)->firstOrFail();
    }

    public function addOrRemoveFromFavourite()
    {
        $entry = TrackInvestorFavorite::query()
            ->where('identifier', $this->fund->fund_symbol)
            ->where('type', TrackInvestorFavorite::TYPE_MUTUAL_FUND)
            ->where('user_id', Auth::id())
            ->first();

        if (!$entry) {
            TrackInvestorFavorite::create([
                'name' => $this->fund->registrant_name,
                'user_id' => Auth::id(),
                'type' => TrackInvestorFavorite::TYPE_MUTUAL_FUND,
                'identifier' => $this->fund->fund_symbol,
            ]);
        } else {
            $entry->delete();
        }

        $this->checkFavourite();
    }

    public function render()
    {
        return view('livewire.ownership.mutual-fund');
    }
}
