<?php

namespace App\Http\Livewire\TrackInvestor;

use Livewire\Component;
use App\Http\Livewire\AsTab;
use Illuminate\Support\Facades\Auth;
use App\Models\TrackInvestorFavorite;
use App\Services\TrackInvestorService;

class Favorites extends Component
{
    use AsTab, HasFilters;

    protected $listeners = [
        'update' => '$refresh',
    ];

    public static function title(): string
    {
        return 'My Favorites';
    }

    public function render()
    {
        $investors = TrackInvestorFavorite::where('user_id', Auth::id())
            ->when($this->search, function ($query) {
                $term = '%' . $this->search . '%';

                return $query->where('name', 'ilike', $term);
            })
            ->get();

        $funds = $investors->where('type', TrackInvestorFavorite::TYPE_FUND)
            ->pluck('identifier')
            ->toArray();

        $mutualFunds = $investors->where('type', TrackInvestorFavorite::TYPE_MUTUAL_FUND)
            ->pluck('identifier')
            ->toArray();

        $filters = $this->formattedFilters();

        $this->loading = false;

        $funds = $this->getFunds($funds, $filters);
        $mutualFunds = $this->getMutualFunds($mutualFunds, $filters);

        return view('livewire.track-investor.favorites', [
            'funds' => $funds,
            'mutualFunds' => $mutualFunds,
            'summaryKey' => $funds->pluck('cik')->join('_') . '||' . $mutualFunds->pluck('fund_symbol')->join('_'),
            'filters' => $filters,
        ]);
    }

    private function getFunds($funds, $filters)
    {
        if (empty($funds)) return collect();

        return app(TrackInvestorService::class)
            ->fundsQuery(
                filters: $filters,
                only: $funds
            )
            ->get()
            // sort the collection by the order of the $funds array
            ->sortBy(fn($item) => array_search($item->cik, $funds))
            ->map(function ($item) {
                $item->type = 'fund';
                $item->isFavorite = true;

                return (array) $item;
            });
    }

    private function getMutualFunds($funds, $filters)
    {
        if (empty($funds)) return collect();

        return app(TrackInvestorService::class)
            ->mutualFundsQuery(
                filters: $filters,
                only: $funds
            )
            ->get()
            ->sortBy(fn($item) => array_search($item->fund_symbol, $funds))
            ->map(function ($item) {
                $item->type = 'mutual-fund';
                $item->isFavorite = true;

                return (array) $item;
            });
    }
}
