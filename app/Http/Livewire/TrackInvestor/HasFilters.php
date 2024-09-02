<?php

namespace App\Http\Livewire\TrackInvestor;

use Illuminate\Support\Facades\Auth;

trait HasFilters
{
    public $perPage = 20;
    public $search = null;
    public $marketValue = null;
    public $turnover = null;
    public $holdings = null;
    public $view = 'most-recent';
    public $loading = false;
    public $listStyle = 'grid';

    public function bootHasFilters()
    {
        $this->listStyle = Auth::user()->getSetting('track_investor_list_style:' . get_class($this), 'grid');
    }

    public function loadMore()
    {
        $this->perPage += 20;
    }

    public function filters()
    {
        return [
            'search' => $this->search,
            'marketValue' => $this->marketValue,
            'turnover' => $this->turnover,
            'holdings' => $this->holdings,
            'view' => $this->view,
        ];
    }

    public function updated($prop)
    {
        if (in_array($prop, ['search', 'marketValue', 'turnover', 'holdings', 'view'])) {
            $this->reset('perPage');
        }

        if ($prop === 'listStyle') {
            Auth::user()->updateSetting('track_investor_list_style:' . get_class($this), $this->listStyle);
        }
    }

    public function toggleListStyle()
    {
        $this->listStyle = $this->listStyle === 'grid' ? 'list' : 'grid';
    }

    private function formattedFilters()
    {
        $formatRange = function ($val, $multiplier = 1000000) {
            if (!(is_array($val) && count($val))) {
                return null;
            }

            return [intval($val[0]) * $multiplier, intval($val[1]) * $multiplier];
        };

        $filters = [
            'search' => trim($this->search) ?: null,
            'marketValue' => $formatRange($this->marketValue),
            'turnover' => $formatRange($this->turnover),
            'holdings' => $formatRange($this->holdings, 1),
            'view' => $this->view ?: 'most-recent',
        ];

        $filters['areApplied'] = collect($filters)->some(fn($val) => $val !== null);

        return $filters;
    }
}
