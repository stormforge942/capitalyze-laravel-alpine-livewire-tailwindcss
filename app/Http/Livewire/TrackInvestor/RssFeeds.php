<?php

namespace App\Http\Livewire\TrackInvestor;

use Livewire\Component;
use App\Http\Livewire\AsTab;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\TrackInvestorFavorite;
use Illuminate\Support\Facades\Cache;

class RssFeeds extends Component
{
    use AsTab, HasFilters;

    protected $listeners = [
        'update' => '$refresh',
    ];

    public $quarters = [];
    public $search = null;
    public $quarter = null;

    public static function title(): string
    {
        return 'RSS Feed';
    }

    public static function key(): string
    {
        return 'rss-feed';
    }

    public function mount()
    {
        $entry = DB::connection('pgsql-xbrl')
            ->table('filings_summary')
            ->select(DB::raw("min(date) as start"), DB::raw("max(date) as end"))
            ->first();

        $start = Carbon::parse($entry->start ?: now()->toDateString());
        $end = Carbon::parse($entry->end ?: now()->toDateString());

        $quarters = generate_quarter_options($start, $end);

        $this->quarters = $quarters;
        if (!array_key_exists($this->quarter, $this->quarters)) {
            $this->quarter = array_key_first($this->quarters);
        }
    }

    public function render()
    {
        return view('livewire.track-investor.rss-feeds');
    }
}
