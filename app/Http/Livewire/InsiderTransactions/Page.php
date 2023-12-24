<?php

namespace App\Http\Livewire\InsiderTransactions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Page extends Component
{
    protected $filters = [];
    protected $relationships = [];

    public function mount(Request $request)
    {
        $this->relationships = $this->getTopInsiderTitles();

        if ($request->query('search')) {
            $this->filters['search'] = $request->query('search');
        }

        if ($request->query('transaction_codes')) {
            $this->filters['transaction_codes'] = array_values(array_filter(
                explode(',', $request->query('transaction_codes')),
                fn ($code) => in_array($code, array_keys(config('capitalyze.transaction_code_map')))
            ));
        }

        if ($request->query('relationships')) {
            $this->filters['relationships'] = array_values(array_filter(
                explode(',', $request->query('relationships')),
                fn ($relationship) => in_array($relationship, $this->relationships)
            ));
        }

        if ($request->query('transaction_value')) {
            [$min, $max] = explode('-', $request->query('transaction_value'));
            $min = intval($min) ?? 0;
            $max = intval($max) ?? 0;

            if ($min || $max) {
                $this->filters['transaction_value'] = [
                    'min' => $min,
                    'max' => $max,
                ];
            }
        }

        if ($request->query('months')) {
            $this->filters['months'] = intval($request->query('months'));
        }

        if ($request->query('cso')) {
            $this->filters['cso'] = intval($request->query('cso'));
        }
    }

    public function render()
    {
        return view('livewire.insider-transactions.page', [
            'insiderTitles' => $this->relationships,
            'filters' => $this->filters,
        ]);
    }

    public function getTopInsiderTitles()
    {
        return DB::connection('pgsql-xbrl')
            ->table('insider_transactions')
            ->select(['relationship_of_reporting_person', DB::raw('count(*) as count')])
            ->groupBy('relationship_of_reporting_person')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->pluck('relationship_of_reporting_person', 'relationship_of_reporting_person')
            ->toArray();
    }
}
