<?php

namespace App\Http\Livewire\InvestorAdviser;

use Illuminate\Support\Facades\Auth;

trait HasFilters
{
    public $perPage = 20;
    public $search = '';
    public $view = 'most-recent';
    public $loading = false;
    public $listStyle = 'grid';

    public function bootHasFilters()
    {
        $this->listStyle = Auth::user()->getSetting('investor_adviser_list_style:' . get_class($this), 'grid');
    }

    public function loadMore()
    {
        $this->perPage += 20;
    }

    public function filters()
    {
        return [
            'search' => $this->search,
            'view' => $this->view,
        ];
    }

    public function updated($prop)
    {
        if (in_array($prop, ['search', 'view'])) {
            $this->reset('perPage');
        }

        if ($prop === 'listStyle') {
            Auth::user()->updateSetting('investor_adviser_list_style:' . get_class($this), $this->listStyle);
        }
    }

    public function toggleListStyle()
    {
        $this->listStyle = $this->listStyle === 'grid' ? 'list' : 'grid';
    }

    private function formattedFilters()
    {
        $filters = [
            'search' => trim($this->search) ?: null,
            'view' => $this->view ?: 'most-recent',
        ];

        $filters['areApplied'] = collect($filters)->some(fn($val) => $val !== null);

        return $filters;
    }
}
