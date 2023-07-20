<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Company;


class EconomicsCalendar extends Component
{
    public $exchanges;
    public $selectedExchange = "all";
    public $startDate;
    public $endDate;
    public $earningsCalls;
    public $week;
    public $company;
    public $period = "annual";

    public function mount()
    {

        // only because of left bar needs a default ticker if clicked on it
        $company = Company::where('ticker', "AAPL")->get()->first();
        $this->company = $company;

        // Initialize start and end dates to the current week
        $this->startDate = Carbon::now()->startOfWeek()->toDateString();
        $this->endDate = Carbon::now()->endOfWeek()->toDateString();

        // Load the economics calls
        $this->loadEconomicReleasesCalls();
        $this->week = Carbon::now()->format('Y-\WW');
    }

    public function nextWeek()
    {
        $this->startDate = Carbon::parse($this->startDate)->addWeek()->startOfWeek()->toDateString();
        $this->endDate = Carbon::parse($this->endDate)->addWeek()->endOfWeek()->toDateString();

        // Reload the economics calls
        $this->loadEconomicReleasesCalls();
    }

    public function previousWeek()
    {
        $this->startDate = Carbon::parse($this->startDate)->subWeek()->startOfWeek()->toDateString();
        $this->endDate = Carbon::parse($this->endDate)->subWeek()->endOfWeek()->toDateString();

        // Reload the economics calls
        $this->loadEconomicReleasesCalls();
    }

    public function selectWeek($week)
    {
        $this->startDate = Carbon::parse($week)->startOfWeek()->toDateString();
        $this->endDate = Carbon::parse($week)->endOfWeek()->toDateString();

        // Reload the economics calls
        $this->loadEconomicReleasesCalls();
    }

    public function render()
    {
        // Reload the economics calls
        $this->loadEconomicReleasesCalls();

        return view('livewire.economics-calendar', [
            'formattedDate' => $this->formatDate($this->week)
        ]);
    }

    public function formatDate($date)
    {
        return Carbon::parse($date)->format('F Y');
    }

    public function loadEconomicReleasesCalls()
    {
        $query = DB::connection('pgsql-xbrl')
            ->table('public.economic_releases')
            ->select('name', 'date', 'source', 'release_id', 'is_press_release')
            ->whereBetween('date', [$this->startDate, $this->endDate]);

        $results1 = $query->orderBy('date', 'desc')->limit(100)->get()->toArray();

        $this->earningsCalls = $results1;
    }

}
