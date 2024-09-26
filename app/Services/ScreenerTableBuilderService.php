<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

class ScreenerTableBuilderService
{
    const TABLE_PER_PAGE = 20;

    public static function makeQuery(array $universalCriteria, array $financialCriteria): Builder
    {
        $query = DB::connection('pgsql-xbrl')
            ->table('company_profile as c')
            ->join('standardized_new as s', 'c.symbol', '=', 's.ticker');

        static::applyUniversalCriteria($query, $universalCriteria ?? []);

        static::applyFinancialCriteria($query, $financialCriteria ?? []);

        return $query;
    }

    public static function generateTableData(Builder $query, array $select, int $page = 1)
    {
        return $query
            ->select($select)
            ->skip(($page - 1) * static::TABLE_PER_PAGE)
            ->take(static::TABLE_PER_PAGE)
            ->get()
            ->map(fn($item) => (array) $item)
            ->toArray();
    }

    public static function generateSummary(Builder $query, array $summaries, array $select)
    {
        $columns = [];

        foreach ($summaries as $summary) {
            foreach ($select as $column) {
                if (!str_starts_with("s.", $column)) continue;

                $label = explode('.', $column)[1];

                switch ($summary) {
                    case 'Min':
                        $columns[] = DB::raw("MIN({$column}) as {$label}_min");
                        break;
                    case 'Max':
                        $columns[] = DB::raw("MAX({$column}) as {$label}_max");
                        break;
                    case 'Avg':
                        $columns[] = DB::raw("AVG({$column}) as {$label}_avg");
                        break;
                    case 'Median':
                        $columns[] = DB::raw("PERCENTILE_CONT(0.5) WITHIN GROUP (ORDER BY {$column}) AS {$label}_median");
                        break;
                }
            }
        }

        return $query
            ->select($columns)
            ->get()
            ->map(fn($item) => (array) $item)
            ->toArray();
    }

    private static function applyUniversalCriteria(Builder $query, array $criterias)
    {
        return $query
            ->when(isset($criterias['locations']), function ($query) use ($criterias) {
                if ($criterias['locations']['exclude']) {
                    $query->whereNotIn('c.country', $criterias['locations']['data']);
                } else {
                    $query->whereIn('c.country', $criterias['locations']['data']);
                }

                return $query;
            })
            ->when(isset($criterias['stock_exchanges']), function ($query) use ($criterias) {
                if ($criterias['stock_exchanges']['exclude']) {
                    $query->whereNotIn('c.exchange', $criterias['stock_exchanges']['data']);
                } else {
                    $query->whereIn('c.exchange', $criterias['stock_exchanges']['data']);
                }

                return $query;
            })
            ->when(isset($criterias['industries']), function ($query) use ($criterias) {
                if ($criterias['industries']['exclude']) {
                    $query->whereNotIn('c.sic_group', $criterias['industries']['data']);
                } else {
                    $query->whereIn('c.sic_group', $criterias['industries']['data']);
                }

                return $query;
            })
            ->when(isset($criterias['sectors']), function ($query) use ($criterias) {
                if ($criterias['sectors']['exclude']) {
                    $query->whereNotIn('c.sic_description', $criterias['sectors']['data']);
                } else {
                    $query->whereIn('c.sic_description', $criterias['sectors']['data']);
                }

                return $query;
            });
    }

    private static function applyFinancialCriteria(Builder $query_, array $criterias)
    {
        $options = ChartBuilderService::options(true);

        foreach ($criterias as $criteria) {
            $key = $criteria['metric'] . '.mapping.' . ($criteria['type'] === 'value' ? 'self' : 'yoy_change');

            $column = data_get($options, $key);

            if (!$column) continue;

            $column = "s." . $column;

            $where = function ($query) use ($criteria, $column) {
                $query->where('s.period_type', $criteria['period']);

                if ($criteria['period'] === 'annual') {
                    $dates = collect(($criteria['dates'] ?? []))
                        ->map(fn($date) => intval(explode(' ', $date)[1]))
                        ->toArray();

                    $query->whereIn('year', $dates);
                } else {
                    $dates = collect(($criteria['dates'] ?? []))
                        ->map(function ($date) {
                            [$quarter, $year] = explode(' ', $date);

                            return [intval($year), intval(ltrim($quarter, 'Q'))];
                        })
                        ->toArray();

                    $query->where(function ($q) use ($dates) {
                        foreach ($dates as $date) {
                            $q->orWhere(fn($q1) => $q1->where('year', $date[0])->where('quarter', $date[1]));
                        }
                    });
                }

                switch ($criteria['operator']) {
                    case '>':
                        $query->where($column, '>', $criteria['value']);
                        break;

                    case '>=':
                        $query->where($column, '>=', $criteria['value']);
                        break;

                    case '<':
                        $query->where($column, '<', $criteria['value']);
                        break;

                    case '<=':
                        $query->where($column, '<=', $criteria['value']);
                        break;

                    case '=':
                        $query->where($column, '=', $criteria['value']);
                        break;

                    case 'between':
                        $query->where($column, '>=', $criteria['value'][0])->where($column, '<=', $criteria['value'][1]);
                        break;

                    default:
                        break;
                }
            };

            $query_->where($where);
        }
    }


    public static function resolveValidCriterias(array $universalCriteria_, array $financialCriteria_)
    {
        $universalCriteria = [];
        foreach (['locations', 'stock_exchanges', 'industries', 'sectors'] as $key) {
            if (count(data_get($universalCriteria_, $key . '.data') ?? [])) {
                $universalCriteria[$key] = $universalCriteria_[$key];
            }
        }
        if ($val = static::range(data_get($universalCriteria, 'market_cap.0'), data_get($universalCriteria, 'market_cap.1'))) {
            $universalCriteria['market_cap'] = $val;
        }

        $financialCriteria = [];
        foreach ($financialCriteria_ as $criteria) {
            if (
                $criteria['metric'] && $criteria['type'] && $criteria['period'] && count($criteria['dates']) && $criteria['operator']
                // if operator is between, then value should be an array with two elements else it should be a single value
                && ($criteria['operator'] === 'between' ? (data_get($criteria, 'value.0') && data_get($criteria, 'value.1')) : data_get($criteria, 'value'))
            ) {
                $financialCriteria[] = $criteria;
            }
        }

        return [
            'universal' => $universalCriteria,
            'financial' => $financialCriteria,
        ];
    }

    private static function range($min, $max)
    {
        if (is_null($min) && is_null($max)) {
            return null;
        }

        if (is_null($min) || is_null($max)) {
            return [$min, $max];
        }

        if ($min > $max) {
            [$min, $max] = [$max, $min];
        }

        return [$min, $max];
    }
}
