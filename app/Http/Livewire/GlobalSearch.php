<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\CompanyProfile;
use App\Models\UserSearchHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;

class GlobalSearch extends Component
{
    public $history = [];
    public $suggestions = [];
    public $checklist = false;

    public function mount()
    {
        $this->history = $this->getSearchHistory();
    }

    private function getLogoUrl($ticker)
    {
        if (Storage::disk('s3')->exists("company_logos/{$ticker}.png")) {
            return Storage::disk('s3')->url("company_logos/{$ticker}.png");
        } else {
            return asset('svg/logo.svg');
        }
    }

    public function getSuggestions($searchString)
    {
        $result = CompanyProfile::selectRaw("
                symbol as ticker,
                registrant_name as name,
                website,
                average_daily_volume,
                CASE
                    WHEN symbol = ? THEN 100
                    WHEN registrant_name = ? THEN 90
                    WHEN symbol ILIKE ? THEN 50
                    ELSE 10
                END as relevance", [$searchString, $searchString, "%{$searchString}%"])
            ->where(function($query) use ($searchString) {
                // Search for partial matches on both symbol and registrant_name
                $query->where('symbol', 'ILIKE', "%{$searchString}%")
                    ->orWhere('registrant_name', 'ILIKE', "%{$searchString}%");
            })
            ->orderBy('relevance', 'desc')
            ->orderByRaw('LENGTH(symbol)')
            ->limit(4)
            ->get()
            ->map(function ($item) {
                $item->logo = $this->getLogoUrl($item->ticker);
                $item->href = route('company.profile', $item->ticker);
                $item->passed = true;
                return $item;
            })
            ->toArray();

        $this->suggestions = $result;
    }

    private function getSearchHistory()
    {
        $model = UserSearchHistory::where('user_id', Auth::user()->id)->first();

        if (!$model) {
            $model = new UserSearchHistory([
                'user_id' => Auth::user()->id,
                'history' => []
            ]);
            $model->save();
            return [];
        }

        $history = $model->history;

        $history = array_map(function ($item) {
            $item['href'] = route('company.profile', $item['ticker']);
            $item['passed'] = true;
            return $item;
        }, $history);

        return $history;
    }

    public function clearHistory()
    {
        $model = UserSearchHistory::firstOrNew(['user_id' => Auth::user()->id]);
        $model->history = [];
        $model->save();
        $this->history = [];
    }

    public function navigateTo($item, $currentUrl = null)
    {
        $model = UserSearchHistory::where('user_id', Auth::user()->id)->first();

        if (!$model) {
            $model = new UserSearchHistory([
                'user_id' => Auth::user()->id,
                'history' => []
            ]);
            $history = [];
        } else {
            $history = $model->history;
        }

        $history = array_filter($history, function($entry) use ($item) {
            return $entry['ticker'] !== $item['ticker'];
        });

        $prevHistoryItem = $history[0] ?? [
            'ticker' => extractTickerFromUrl($currentUrl),
            'name' => null
        ];

        $history[] = [
            'name' => $item['name'],
            'ticker' => $item['ticker'],
        ];

        if (count($history) > 4) {
            $history = array_slice($history, -4);
        }

        $model->history = array_reverse($history);
        $model->save();

        $routeName = getRouteNameFromUrl($currentUrl);

        if (str_starts_with($routeName, 'company.')) {
            $prevTicker = $prevHistoryItem['ticker'];
            $newUrl = str_replace($prevTicker, $item['ticker'], $currentUrl);
        } else {
            $newUrl = parse_url(route('company.profile', $item['ticker']), PHP_URL_PATH);
        }

        return $newUrl;
    }

    public function render()
    {
        return view('livewire.global-search');
    }
}
