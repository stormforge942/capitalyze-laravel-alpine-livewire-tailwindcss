<?php

namespace App\Http\Livewire\InvestorAdviser;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Services\InvestorAdviserService;

class Page extends Component
{
    use HasFilters;

    protected $listeners = [
        'update' => '$refresh',
    ];

    public $views = ['most-recent'];

    public function mount()
    {
        $entry = DB::connection('pgsql-xbrl')
            ->table('investment_advisers')
            ->select(DB::raw('min(date) as start'), DB::raw('max(date) as end'))
            ->first();

        $start = Carbon::parse($entry->start ?: now()->toDateString());
        $end = Carbon::parse($entry->end ?: now()->toDateString());

        $months = generate_month_options($start, $end);

        $this->views = [
            'most-recent' => 'Most Recent',
            ...$months,
        ];
    }

    private function getAdvisers(array $filters)
    {
        $cacheKey = $filters['areApplied'] ? null : 'advisers_' . md5($this->search . '_view_' . $this->view . '_perPage_' . $this->perPage);

        $cb = fn() => app(InvestorAdviserService::class)
            ->buildQuery($filters, $this->views)
            ->orderBy('date', 'desc')
            ->paginate($this->perPage);

        $advisers = $cacheKey ? Cache::remember($cacheKey, 3600, $cb) : $cb();

        return $advisers;
    }

    public function render()
    {
        $filters = $this->formattedFilters();

        $this->loading = false;

        return view('livewire.investor-adviser.page', [
            'advisers' => $this->listStyle === 'grid' ? $this->getAdvisers($filters) : null,
            'filters' => $filters,
        ]);
    }
}
