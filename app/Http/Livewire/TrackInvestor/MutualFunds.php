<?php

namespace App\Http\Livewire\TrackInvestor;

use App\Http\Livewire\AsTab;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\TrackInvestorFavorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class MutualFunds extends Component
{
    use AsTab;

    protected $listeners = [
        'update' => '$refresh',
        'search:mutual-funds' => 'updatedSearch',
    ];

    public $perPage = 20;
    public $search = "";

    public static function title(): string
    {
        return 'N-PORT Filers';
    }

    public static function key(): string
    {
        return 'mutual-funds';
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
        $cacheKey = 'mutual_funds_' . md5($this->search . '_perPage_' . $this->perPage);
    
        $cacheDuration = 3600;

        $funds = Cache::remember($cacheKey, $cacheDuration, function () {
            return DB::connection('pgsql-xbrl')
                ->table('mutual_fund_holdings_summary')
                ->select('registrant_name', 'fund_symbol', 'cik', 'series_id', 'class_id', 'class_name', 'total_value', 'portfolio_size', 'change_in_total_value', 'date')
                ->where('is_latest', true)
                ->when($this->search, function ($query) {
                    return $query->where(DB::raw('registrant_name'), 'ilike', "%{$this->search}%")
                                 ->orWhere(DB::raw('fund_symbol'), 'ilike', "%{$this->search}%");
                })
                ->orderBy('total_value', 'desc')
                ->paginate($this->perPage);
        });
    
        $favorites = TrackInvestorFavorite::where('user_id', Auth::id())
                                           ->where('type', TrackInvestorFavorite::TYPE_MUTUAL_FUND)
                                           ->pluck('identifier')
                                           ->toArray();
    
        $transformedFunds = $funds->getCollection()->map(function ($fund) use ($favorites) {
            $fundArray = (array)$fund;
            $fundArray['isFavorite'] = in_array($fundArray['cik'], $favorites);
            return $fundArray;
        });
    
        $funds->setCollection(collect($transformedFunds));
    
        return view('livewire.track-investor.mutual-funds', [
            'funds' => $funds,
        ]);
    }
    
    
}
