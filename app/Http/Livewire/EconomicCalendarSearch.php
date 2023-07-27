<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class EconomicCalendarSearch extends Component
{
    public $search;
    public $resultsSearch = [];
    public $showText = false;
    protected $listeners = ['showText'];

    public function updatedSearch()
    {
        $this->resultsSearch = DB::connection('pgsql-xbrl')
        ->table('public.data_series')
        ->where('title', 'ilike', '%' . $this->search . '%')
        ->limit(10)
        ->get()
        ->toArray();
    }

    public function showText()
    {
        $this->showText = true;
    }

    public function hideText()
    {
        $this->showText = false;
    }

    public function render()
    {
        return view('livewire.economic-calendar-search');
    }
}
