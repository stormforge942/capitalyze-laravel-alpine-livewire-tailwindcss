<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\CompanyProfile;
use App\Models\UserSearchHistory;
use Illuminate\Support\Facades\Auth;

class GlobalSearch extends Component
{
    public $search = '';
    public $history = [];
    public $suggestions = [];
    public $checklist = false;

    public function mount()
    {
        $this->history = $this->getSearchHistory();
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
            return $item;
        }, $history);

        return $history;
    }

    public function getLogoFromWebsite($website)
    {
        $host = parse_url($website, PHP_URL_HOST);
        $domain = preg_replace('/^www\./', '', $host);
        $key = config('services.logo.key');
        return "https://img.logo.dev/{$domain}?token={$key}";
    }

    public function updated($propertyName)
    {
        if ($propertyName === 'search') {
            $result = CompanyProfile::query()
                ->select('symbol as ticker', 'registrant_name as name', 'website', 'average_daily_volume')
                ->when($this->search, fn ($query) =>  $query->where('registrant_name', 'ilike', '%' . $this->search . '%'))
                ->orderBy('average_daily_volume', 'desc')
                ->limit(4)
                ->get()
                ->map(function ($item) {
                    $item->logo = $this->getLogoFromWebsite($item->website);
                    $item->href = route('company.profile', $item->ticker);
                    return $item;
                })
                ->toArray();

            $this->suggestions = $result;
        }
    }

    public function clearHistory()
    {
        $model = UserSearchHistory::firstOrNew(['user_id' => Auth::user()->id]);
        $model->history = [];
        $model->save();
        $this->history = [];
    }

    public function navigateTo($item)
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

        $history[] = [
            'name' => $item['name'],
            'ticker' => $item['ticker'],
        ];

        if (count($history) > 4) {
            $history = array_slice($history, -4);
        }

        $history = array_reverse($history);

        $model->history = $history;
        $model->save();
    }

    public function render()
    {
        return view('livewire.global-search');
    }
}
