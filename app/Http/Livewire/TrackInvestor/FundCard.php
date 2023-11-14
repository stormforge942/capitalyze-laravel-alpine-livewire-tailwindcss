<?php

namespace App\Http\Livewire\TrackInvestor;

use Livewire\Component;
use App\Models\TrackInvestorFavorite;

class FundCard extends Component
{
    public $fund;
    public $hideIfNotFavorite = false;

    public function toggle(string $name)
    {
        $entry = TrackInvestorFavorite::where('investor_name', $name)
            ->where('user_id', auth()->user()->id)
            ->first();

        $isFavorite = $entry ? false : true;

        if (!$entry) {
            TrackInvestorFavorite::create([
                'investor_name' => $name,
                'user_id' => auth()->user()->id
            ]);
        } else {
            $entry->delete();
        }

        $this->fund['isFavorite'] = $isFavorite;

        if($this->hideIfNotFavorite) {
            $this->emitTo(Discover::class, 'update');
        }

        $this->emitTo(Favorites::class, 'update');
    }


    public function render()
    {
        return view('livewire.track-investor.fund-card');
    }
}
