<?php

namespace App\Services;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class InvestorAdviserService
{
    public function buildQuery(array $filters, array $views = []): Builder
    {
        $q = DB::connection('pgsql-xbrl')
            ->table('investment_advisers')
            ->select(['legal_name', 'cik', 'date', 'number_of_employees', 'assets_under_management', 'number_of_accounts']);

        if ($filters['view'] != 'most-recent') {
            $q->where('date', $filters['view']);
        } else {
            $currentDate = now();
            $lastMonth = $currentDate->subMonth()->format('Y-m');
            $q->where('date', $lastMonth);
        }

        $q = $q->when(
            $filters['search'],
            fn($query) => $query->where(
                fn($q) => $q->where(DB::raw('legal_name'), 'ilike', "%{$filters['search']}%")
                    ->orWhere(DB::raw('cik'), $filters['search'])
            ));

        return $q;
    }
}
