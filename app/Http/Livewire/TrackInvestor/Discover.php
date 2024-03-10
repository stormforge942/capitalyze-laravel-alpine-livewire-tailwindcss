<?php

namespace App\Http\Livewire\TrackInvestor;

use App\Http\Livewire\AsTab;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\TrackInvestorFavorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Discover extends Component
{
    use AsTab;

    protected $listeners = [
        'update' => '$refresh',
        'search:discover' => 'updatedSearch',
    ];

    public $perPage = 20;
    public $search = "";

    public static function title(): string
    {
        return '13F Filers';
    }

    public static function key(): string
    {
        return 'discover';
    }

    public function loadMore()
    {
        $this->perPage += 20;
    }

    public function updatedSearch($search)
    {
        $this->search = $search;
        $this->reset('perPage');
    }

    public function render()
    {
        $cacheKey = 'funds_'.md5($this->search.'_perPage_'.$this->perPage);

        $funds = Cache::remember($cacheKey, 360, function () {
            return DB::connection('pgsql-xbrl')
                ->table('filings_summary')
                ->select('investor_name', 'cik', 'total_value', 'portfolio_size', 'change_in_total_value')
                ->where('is_latest', true)
                ->when($this->search, function ($q) {
                    return $q->where(DB::raw('investor_name'), 'ilike', "%$this->search%")
                             ->orWhere(DB::raw('cik'), $this->search);
                })
                ->orderBy('total_value', 'desc')
                ->paginate($this->perPage);
        });

        $favorites = TrackInvestorFavorite::query()
            ->where('user_id', Auth::id())
            ->where('type', TrackInvestorFavorite::TYPE_FUND)
            ->pluck('identifier')
            ->toArray();

        $funds->getCollection()->transform(function ($item) use ($favorites) {
            $item->isFavorite = in_array($item->cik, $favorites);
            return $item;
        });

        return view('livewire.track-investor.discover', [
            'funds' => $funds,
        ]);
    }

}
