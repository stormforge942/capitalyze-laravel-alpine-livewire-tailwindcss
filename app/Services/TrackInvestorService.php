<?php

namespace App\Services;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class TrackInvestorService
{
    public function fundsQuery(array $filters, array $views = [], ?array $only = null): Builder
    {
        $q = DB::connection('pgsql-xbrl')
            ->table('filings_summary')
            ->select('investor_name', 'cik', 'total_value', 'portfolio_size', 'change_in_total_value', 'date');

        if ($filters['view'] == 'all' || $only) {
            $q->where('is_latest', true);
        } else if ($filters['view'] === 'most-recent') {
            $quarters = array_keys($views);

            $q->whereIn('date', [$quarters[2] ?? 'wrong-date', $quarters[3] ?? 'wrong-date'])
                ->where('is_latest', true);
        } else {
            $q->where('date', $filters['view']);
        }

        if ($only) {
            $q->whereIn('cik', $only);
        }

        $q = $q->when(
            $filters['search'],
            fn($query) => $query->where(
                fn($q) => $q->where(DB::raw('investor_name'), 'ilike', "%{$filters['search']}%")
                    ->orWhere(DB::raw('cik'), $filters['search'])
            )
        )
            ->when($filters['marketValue'], function ($query) use ($filters) {
                return $query->whereBetween('total_value', $filters['marketValue']);
            })
            ->when($filters['turnover'], function ($query) use ($filters) {
                return $query->whereBetween('change_in_total_value', $filters['turnover']);
            })
            ->when($filters['holdings'], function ($query) use ($filters) {
                return $query->whereBetween('portfolio_size', $filters['holdings']);
            });

        return $q;
    }

    public function mutualFundsQuery(array $filters, array $views = [], ?array $only = null): Builder
    {
        $q = DB::connection('pgsql-xbrl')
            ->table('mutual_fund_holdings_summary')
            ->select('registrant_name', 'fund_symbol', 'cik', 'series_id', 'class_id', 'class_name', 'total_value', 'portfolio_size', 'change_in_total_value', 'date');

        if ($filters['view'] == 'all' || $only) {
            $q->where('is_latest', true);
        } else if ($filters['view'] === 'most-recent') {
            $quarters = array_keys($views);

            $q->whereIn('date', [$quarters[2] ?? 'wrong-date', $quarters[3] ?? 'wrong-date'])
                ->where('is_latest', true);
        } else {
            $q->where('date', $filters['view']);
        }

        if ($only) {
            $q->whereIn('fund_symbol', $only);
        }

        $q = $q->when(
            $filters['search'],
            fn($query) => $query->where(
                fn($q) => $q->where(DB::raw('registrant_name'), 'ilike', "%{$filters['search']}%")
                    ->orWhere(DB::raw('fund_symbol'), 'ilike', "%{$filters['search']}%")
            )
        )
            ->when(
                $filters['marketValue'],
                fn($q) => $q->whereBetween('total_value', $filters['marketValue'])
            )
            ->when(
                $filters['turnover'],
                fn($q) => $q->whereBetween('change_in_total_value', $filters['turnover'])
            )
            ->when(
                $filters['holdings'],
                fn($q) => $q->whereBetween('portfolio_size', $filters['holdings'])
            );

        return $q;
    }
}
