<?php

namespace App\Http\Livewire\TrackInvestor;

use Livewire\Component;
use App\Models\TrackInvestorFavorite;
use Illuminate\Support\Facades\Auth;

class FundCard extends Component
{
    public $fund;
    public $hideIfNotFavorite = false;

    public function toggle(array $fund)
    {
        $entry = TrackInvestorFavorite::query()
            ->where('identifier', $fund['cik'])
            ->where('type', TrackInvestorFavorite::TYPE_FUND)
            ->where('user_id', Auth::id())
            ->first();

        $isFavorite = $entry ? false : true;

        if (!$entry) {
            TrackInvestorFavorite::create([
                'name' => $fund['investor_name'],
                'user_id' => Auth::id(),
                'type' => TrackInvestorFavorite::TYPE_FUND,
                'identifier' => $fund['cik'],
            ]);
        } else {
            $entry->delete();
        }

        $this->fund['isFavorite'] = $isFavorite;

        if ($this->hideIfNotFavorite) {
            $this->emitTo(Discover::class, 'update');
        }

        $this->emitTo(Favorites::class, 'update');
    }


    public function render()
    {
        return view('livewire.track-investor.fund-card');
    }
}
