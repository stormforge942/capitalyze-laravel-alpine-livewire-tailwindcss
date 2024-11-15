<?php

namespace App\Http\Livewire\InvestorAdviser;

use App\Models\InvestmentAdvisers;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class AdviserGraph extends Component
{
    public $adviser;
    public $chartData = [];

    public $name;

    public function mount($legalName)
    {
        $cacheKey = 'investor_adviser_graph' . $legalName;
        $cacheDuration = 3600;

        $this->adviser = Cache::remember($cacheKey, $cacheDuration, function () use ($legalName) {
            return InvestmentAdvisers::find($legalName);
        });

        $this->name = $legalName;
        $this->load();
    }

    public function load()
    {
        $this->chartData = [
            'dataset1' => [],
            'dataset2' => [],
            'dataset3' => [],
        ];

        $cacheKey = 'advisers_' . strtolower($this->adviser->legal_name);
        $cacheDuration = 3600;
        $result = Cache::remember($cacheKey, $cacheDuration, function () {
            return DB::connection('pgsql-xbrl')
                ->table('investment_advisers')
                ->select('date', 'number_of_employees', 'assets_under_management', 'number_of_accounts')
                ->where('legal_name', $this->adviser->legal_name)
                ->orderBy('date')
                ->get();
        });
        
        $result->each(function ($quote) {
            $this->chartData['dataset1'][] = [
                'x' => $quote->date,
                'y' => $quote->assets_under_management,
                'source' => number_format($quote->assets_under_management, 4),
            ];

            $this->chartData['dataset2'][] = [
                'x' => $quote->date,
                'y' => number_format($quote->number_of_employees),
            ];

            $this->chartData['dataset3'][] = [
                'x' => $quote->date,
                'y' => number_format($quote->number_of_accounts),
            ];
        });
    }

    public function render()
    {
        return view('livewire.investor-adviser.adviser-graph');
    }
}
