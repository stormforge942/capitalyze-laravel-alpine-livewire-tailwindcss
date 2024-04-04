<?php

namespace App\Http\Livewire\TrackInvestor;

trait HasFilters
{
    public $perPage = 20;
    public $search = null;
    public $marketValue = null;
    public $turnover = null;
    public $holdings = null;

    public function loadMore()
    {
        $this->perPage += 20;
    }

    public function updated($prop)
    {
        if (in_array($prop, ['search', 'marketValue', 'turnover', 'holdings'])) {
            $this->reset('perPage');
        }
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
        ];

        $filters['areApplied'] = collect($filters)->some(fn ($val) => $val !== null);

        return $filters;
    }
}
