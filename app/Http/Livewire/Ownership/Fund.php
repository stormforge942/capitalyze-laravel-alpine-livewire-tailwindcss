<?php

namespace App\Http\Livewire\Ownership;

use Livewire\Component;
use App\Models\CompanyInsider;
use App\Services\OwnershipHistoryService;
use App\Models\TrackInvestorFavorite;
use Illuminate\Support\Facades\Auth;

class Fund extends Component
{
    public $company;
    public $fund;
    public $isFavourite;

    public $tabs = [
        FundSummary::class,
        FundHoldings::class,
    ];

    public function mount($fund, $company = null)
    {
        $this->fund = $fund;
        $this->company = $company;

        $this->checkFavourite();

        OwnershipHistoryService::push([
            'name' => $this->fund->name,
            'url' => request()->url(),
        ]);
    }

    public function checkFavourite()
    {
        $entry = TrackInvestorFavorite::query()
            ->where('user_id', Auth::id())
            ->where('type', TrackInvestorFavorite::TYPE_FUND)
            ->where('identifier', $this->fund->cik)
            ->get();

        $this->isFavorite = $entry->count() ? true : false;
    }

    public function addOrRemoveFromFavourite()
    {
        // Remove from favourite
        $entry = TrackInvestorFavorite::query()
            ->where('identifier', $this->fund->cik)
            ->where('type', TrackInvestorFavorite::TYPE_FUND)
            ->where('user_id', Auth::id())
            ->get();
                    
        if ($entry->count() == 0) {
            TrackInvestorFavorite::create([
                'name' => $this->fund->name,
                'user_id' => Auth::id(),
                'type' => TrackInvestorFavorite::TYPE_FUND,
                'identifier' => $this->fund->cik,
            ]);
        } else {
            foreach ($entry as $item) {
                $item->delete();
            }
        }

        $this->checkFavourite();
    }

    public function render()
    {
        return view('livewire.ownership.fund');
    }
}
