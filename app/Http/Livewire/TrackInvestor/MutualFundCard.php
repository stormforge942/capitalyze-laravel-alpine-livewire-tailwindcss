<?php

namespace App\Http\Livewire\TrackInvestor;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\TrackInvestorFavorite;

class MutualFundCard extends Component
{
    public $fund;
    public $hideIfNotFavorite = false;

    public function toggle()
    {
        $entry = TrackInvestorFavorite::query()
            ->where('identifier', $this->fund['id'])
            ->where('type', TrackInvestorFavorite::TYPE_MUTUAL_FUND)
            ->where('user_id', Auth::id())
            ->first();

        $isFavorite = $entry ? false : true;

        if (!$entry) {
            TrackInvestorFavorite::create([
                'name' => $this->fund['registrant_name'],
                'user_id' => Auth::id(),
                'type' => TrackInvestorFavorite::TYPE_MUTUAL_FUND,
                'identifier' => $this->fund['id'],
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
        return view('livewire.track-investor.mutual-fund-card', [
            'url' => route(
                'company.mutual-fund',
                [
                    'cik' => $this->fund['cik'],
                    'fund_symbol' => $this->fund['fund_symbol'],
                    'series_id' => $this->fund['series_id'],
                    'class_id' => $this->fund['class_id'],
                    'class_name' => $this->fund['class_name'],
                    'tab' => 'holdings',
                    'from' => 'track-investors',
                ]
            )
        ]);
    }
}
