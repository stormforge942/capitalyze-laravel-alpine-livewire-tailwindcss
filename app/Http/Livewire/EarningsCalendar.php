<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EarningsCalendar extends Component
{
    public $exchanges;
    public $selectedExchange = "all";
    public $startDate;
    public $endDate;
    public $earningsCalls;
    public $week;

    public function mount()
    {
        $this->exchanges = DB::connection('pgsql-xbrl')->table('new_earnings')->select('exchange')->distinct()->pluck('exchange')->toArray();
        $this->selectedExchange = 'all';

        // Initialize start and end dates to the current month
        $this->startDate = Carbon::now()->startOfWeek()->toDateString();
        $this->endDate = Carbon::now()->endOfWeek()->toDateString();

        // Load the earnings calls
        $this->loadEarningsCalls();
        $this->week = Carbon::now()->format('Y-\WW');
    }

    public function nextWeek()
    {
        $this->startDate = Carbon::parse($this->startDate)->addWeek()->startOfWeek()->toDateString();
        $this->endDate = Carbon::parse($this->endDate)->addWeek()->endOfWeek()->toDateString();

        // Reload the earnings calls
        $this->loadEarningsCalls();
    }

    public function previousWeek()
    {
        $this->startDate = Carbon::parse($this->startDate)->subWeek()->startOfWeek()->toDateString();
        $this->endDate = Carbon::parse($this->endDate)->subWeek()->endOfWeek()->toDateString();

        // Reload the earnings calls
        $this->loadEarningsCalls();
    }

    public function selectWeek($week)
    {
        $this->startDate = Carbon::parse($week)->startOfWeek()->toDateString();
        $this->endDate = Carbon::parse($week)->endOfWeek()->toDateString();

        // Reload the earnings calls
        $this->loadEarningsCalls();
    }

    public function render()
    {
        // Reload the earnings calls
        $this->loadEarningsCalls();

        return view('livewire.earnings-calendar', [
            'formattedDate' => $this->formatDate($this->week)
        ]);
    }

    public function formatDate($date)
    {
        return Carbon::parse($date)->format('F Y');
    }

    public function loadEarningsCalls()
    {
        $query = DB::connection('pgsql-xbrl')
            ->table('new_earnings')
            ->select('symbol', 'date', 'exchange', 'time', 'title', 'url', 'company_name', 'acceptance_time')
            ->whereBetween('date', [$this->startDate, $this->endDate]);
    
        if ($this->selectedExchange !== 'all') {
            $query->where('exchange', $this->selectedExchange);
        }

        $query_second = DB::connection('pgsql-xbrl')
            ->table('earnings_calendar')
            ->select('symbol', 'date', 'exchange', 'time', 'title', 'url', 'pub_date')
            ->whereBetween('date', [$this->startDate, $this->endDate]);
    
        if ($this->selectedExchange !== 'all') {
            $query_second->where('exchange', $this->selectedExchange);
        }

        $results1 = $query->get();
        $results2 = $query_second->get();

        $results1->each(function ($result) {
            $result->origin = '8-K';
        });
    
        $results2->each(function ($result) {
            $result->origin = 'press-release';
        });
        
        $this->earningsCalls = $results1->concat($results2)->sortBy(function ($result) {
            $dateTime = Carbon::parse($result->date . ' ' . $result->time);
            return $dateTime->format('YmdHis');
        });
    }
    
}
