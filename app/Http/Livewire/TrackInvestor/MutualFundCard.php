<?php

namespace App\Http\Livewire\TrackInvestor;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\TrackInvestorFavorite;

class MutualFundCard extends Component
{
    public $fund;
    public $hideIfNotFavorite = false;

    public function toggle(array $fund)
    {
        $entry = TrackInvestorFavorite::query()
            ->where('identifier', $fund['id'])
            ->where('type', TrackInvestorFavorite::TYPE_MUTUAL_FUND)
            ->where('user_id', Auth::id())
            ->first();

        $isFavorite = $entry ? false : true;

        if (!$entry) {
            TrackInvestorFavorite::create([
                'investor_name' => $fund['registrant_name'],
                'user_id' => Auth::id(),
                'type' => TrackInvestorFavorite::TYPE_MUTUAL_FUND,
                'identifier' => $fund['id'],
            ]);
        } else {
            $entry->delete();
        }

        $this->fund['isFavorite'] = $isFavorite;

        if ($this->hideIfNotFavorite) {
            $this->emitTo(MutualFunds::class, 'update');
        }

        $this->emitTo(Favorites::class, 'update');
    }


    public function render()
    {
        return view('livewire.track-investor.mutual-fund-card');
    }
}
