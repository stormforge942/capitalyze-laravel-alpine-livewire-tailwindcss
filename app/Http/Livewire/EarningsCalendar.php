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
    public $month;

    public function mount()
    {
        $this->exchanges = DB::connection('pgsql-xbrl')->table('new_earnings')->select('exchange')->distinct()->pluck('exchange')->toArray();
        $this->selectedExchange = 'all';

        // Initialize start and end dates to the current month
        $this->startDate = Carbon::now()->startOfMonth()->toDateString();
        $this->endDate = Carbon::now()->endOfMonth()->toDateString();

        // Load the earnings calls
        $this->loadEarningsCalls();
        $this->month = Carbon::now()->format('Y-m');
    }

    public function nextMonth()
    {
        $this->startDate = Carbon::parse($this->startDate)->addMonth()->startOfMonth()->toDateString();
        $this->endDate = Carbon::parse($this->endDate)->addMonth()->endOfMonth()->toDateString();

        // Reload the earnings calls
        $this->loadEarningsCalls();
    }

    public function previousMonth()
    {
        $this->startDate = Carbon::parse($this->startDate)->subMonth()->startOfMonth()->toDateString();
        $this->endDate = Carbon::parse($this->endDate)->subMonth()->endOfMonth()->toDateString();

        // Reload the earnings calls
        $this->loadEarningsCalls();
    }

    public function selectMonth($month)
    {
        $this->startDate = Carbon::parse($month)->startOfMonth()->toDateString();
        $this->endDate = Carbon::parse($month)->endOfMonth()->toDateString();

        // Reload the earnings calls
        $this->loadEarningsCalls();
    }

    public function render()
    {
        // Reload the earnings calls
        $this->loadEarningsCalls();

        return view('livewire.earnings-calendar', [
            'formattedDate' => $this->formatDate($this->month)
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
            ->select('symbol', 'date', 'exchange', 'time', 'title', 'url', 'company_name')
            ->whereBetween('date', [$this->startDate, $this->endDate]);
    
        if ($this->selectedExchange !== 'all') {
            $query->where('exchange', $this->selectedExchange);
        }

        $query_second = DB::connection('pgsql-xbrl')
            ->table('earnings_calendar')
            ->select('symbol', 'date', 'exchange', 'time', 'title', 'url')
            ->whereBetween('date', [$this->startDate, $this->endDate]);
    
        if ($this->selectedExchange !== 'all') {
            $query_second->where('exchange', $this->selectedExchange);
        }

        $results1 = $query->get();
        $results2 = $query_second->get();
        
        $this->earningsCalls = $results1->concat($results2)->sortBy('date');
    }
    
}
