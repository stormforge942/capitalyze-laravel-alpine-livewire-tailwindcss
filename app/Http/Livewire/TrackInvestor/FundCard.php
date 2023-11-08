<?php

namespace App\Http\Livewire\TrackInvestor;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\TrackInvestorFavorite;

class FundCard extends Component
{
    public $fund;

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

        $this->emitTo(Favorites::class, 'update');
    }


    public function render()
    {
        return view('livewire.track-investor.fund-card');
    }
}
