<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Company;


class EconomicsCalendar extends Component
{
    public $startDate;
    public $endDate;
    public $economicEvents;
    public $outputEventsData;
    public $week;
    public $company;
    public $period = "annual";
    public $formattedDate;
    public $is_last_events = false;

    public function mount()
    {

        // only because of left bar needs a default ticker if clicked on it
        $company = Company::where('ticker', "AAPL")->get()->first();
        $this->company = $company;

        // Initialize start and end dates to the current week
        $this->startDate = Carbon::now()->startOfWeek()->toDateString();
        $this->endDate = Carbon::now()->endOfWeek()->toDateString();

        // Load the economics events
        $this->loadEconomicEvents();
        $this->week = Carbon::now()->format('Y-\WW');
    }

    public function nextWeek()
    {
        $this->startDate = Carbon::parse($this->startDate)->addWeek()->startOfWeek()->toDateString();
        $this->endDate = Carbon::parse($this->endDate)->addWeek()->endOfWeek()->toDateString();

        $this->week = Carbon::parse($this->startDate)->format('Y-\WW');

        // Reload the economics events
        $this->loadEconomicEvents();
    }

    public function previousWeek()
    {
        $this->startDate = Carbon::parse($this->startDate)->subWeek()->startOfWeek()->toDateString();
        $this->endDate = Carbon::parse($this->endDate)->subWeek()->endOfWeek()->toDateString();

        $this->week = Carbon::parse($this->startDate)->format('Y-\WW');

        // Reload the economics events
        $this->loadEconomicEvents();
    }

    public function selectWeek($week)
    {
        $this->startDate = Carbon::parse($week)->startOfWeek()->toDateString();
        $this->endDate = Carbon::parse($week)->endOfWeek()->toDateString();

        // Reload the economics events
        $this->loadEconomicEvents();
    }

    public function render()
    {
        $this->is_last_events = false;
        $this->outputEventsData = [];

        // Reload the economics events
        $this->loadEconomicEvents();

        $this->formattedDate = $this->formatDate($this->week);

        $this->prepareOutput();

        return view('livewire.economics-calendar');
    }

    public function formatDate($date)
    {
        return Carbon::parse($date)->format('F Y');
    }

    public function loadEconomicEvents()
    {
        $query = DB::connection('pgsql-xbrl')
            ->table('public.economic_releases')
            ->select('name', 'date', 'source', 'release_id', 'is_press_release')
            ->whereBetween('date', [$this->startDate, $this->endDate]);

        $results = $query->orderBy('date', 'desc')->limit(100)->get()->toArray();

        $this->economicEvents = $results ? $results : $this->lastEconomicEvents();
    }

    public function lastEconomicEvents()
    {
        $this->is_last_events = true;
        return $query = DB::connection('pgsql-xbrl')
        ->table('public.economic_releases')
        ->select('name', 'date', 'source', 'release_id', 'is_press_release')
        ->orderBy('date', 'desc')->limit(10)->get()->toArray();
    }

    public function prepareOutput()
    {
        foreach ($this->economicEvents as $event) {
            $this->outputEventsData[$event->date][] = $event;
        }
    }
}
