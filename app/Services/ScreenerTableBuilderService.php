<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Query\Builder;

class ScreenerTableBuilderService
{
    public const TABLE_PER_PAGE = 20;

    public static function options($flattened = false)
    {
        $options = config('capitalyze.standardized_metrics');

        if (!$flattened) {
            return $options;
        }

        $flattenedOptions = [];

        foreach ($options as $option) {
            if ($option['has_children']) {
                foreach ($option['items'] as $items) {
                    foreach ($items as $key => $item) {
                        $flattenedOptions[$key] = $item;
                    }
                }
            } else {
                foreach ($option['items'] as $key => $item) {
                    $flattenedOptions[$key] = $item;
                }
            }
        }

        return $flattenedOptions;
    }

    public static function viewOptions($flattened = false)
    {
        $options = [];

        foreach (config('capitalyze.standardized_metrics') as $option) {
            $item = [
                'title' => $option['title'],
            ];

            if ($option['has_children']) {
                $item['items'] = collect(array_values($option['items']))->reduce(fn($c, $i) => array_merge($c, $i), []);
            } else {
                $item['items'] = $option['items'];
            }

            $options[] = $item;
        }

        if (!$flattened) {
            return $options;
        }

        $flattenedOptions = [];

        foreach ($options as $option) {
            foreach ($option['items'] as $key => $item) {
                $flattenedOptions[$key] = $item;
            }
        }

        return $flattenedOptions;
    }

    public static function makeQuery(array $universalCriteria, array $financialCriteria): Builder
    {
        $hasUniversalCriteria = count(array_keys($universalCriteria ?? []));
        $hasFinancialCriteria = count($financialCriteria ?? []);

        $query = DB::connection('pgsql-xbrl')
            ->table('company_profile as c')
            ->join('standardized_new as s', 'c.symbol', '=', 's.ticker');

        if ($hasUniversalCriteria) {
            static::applyUniversalCriteria($query, $universalCriteria ?? []);
        }

        if ($hasFinancialCriteria) {
            static::applyFinancialCriteria($query, $financialCriteria ?? []);
        }

        return $query;
    }

    public static function generateTableData(Builder $query, array $select_ = [], int $page = 1)
    {
        $columns = array_map(fn($item) => ("c." . $item), Arr::pluck($select_['simple'], 'column'));

        // get all unique company profiles
        $result = $query->select($columns)
            ->distinct()
            ->skip(($page - 1) * static::TABLE_PER_PAGE)
            ->take(static::TABLE_PER_PAGE)
            ->get();

        if (!count($select_['complex'])) {
            return $result->map(fn($item) => (array) $item)->toArray();
        }

        $select = [];
        $dates = [];

        foreach ($select_['complex'] as $item) {
            $select[$item['column']] = $item['column'];

            $dates[implode('-', Arr::wrap($item['date']))] = $item['date'];
        }

        $select = [
            'ticker',
            'year',
            'quarter',
            'period_type',
            ...array_values($select),
        ];

        $standardData = DB::connection('pgsql-xbrl')
            ->table('standardized_new')
            ->whereIn('ticker', $result->pluck('symbol')->toArray())
            ->select($select)
            ->where(function ($query) use ($dates) {
                foreach ($dates as $date) {
                    if (is_array($date)) {
                        $query->orWhere([
                            'year' => $date[0],
                            'quarter' => $date[1],
                            'period_type' => 'quarter',
                        ]);
                    } else {
                        $query->orWhere([
                            'year' => $date,
                            'period_type' => 'annual',
                        ]);
                    }
                }

                return $query;
            })
            ->get()
            ->groupBy('ticker');

        $returnable = [];

        foreach ($result as $item) {
            $dates = [];

            $_data = $standardData
                ->get($item->symbol)
                ?->map(function ($i) {
                    $i = (array) $i;
                    unset($i['ticker']);
                    return $i;
                })
                ?->toArray() ?? [];

            $data = [];
            foreach ($_data as $value) {
                $keys = array_filter(array_keys($value), fn($key) => in_array(substr($key, 0, 3), ['si_', 'is_', 'bs_', 'cf_', 'ra_']));

                foreach ($keys as $key) {
                    if ($value['period_type'] === 'annual') {
                        $data[$key . "_" . $value['year']] = $value[$key];
                    }

                    if ($value['period_type'] === 'quarter') {
                        $data[$key . "_" . $value['year'] . "_" . $value['quarter']] = $value[$key];
                    }
                }
            }

            $returnable[] = [
                ...((array) $item),
                'standard_data' => $data,
            ];
        }

        return $returnable;
    }

    public static function generateSummary(Builder $query, array $summaries, array $select = [])
    {
        $numericSimple = Arr::where($select['simple'], fn($item) => $item['is_numeric'] ?? false);

        if (!count($numericSimple) || !count($select['complex'])) {
            return [];
        }

        $columns = [];

        foreach ($summaries as $summary) {
            foreach ($numericSimple as $item) {
                $column = 'c.' . $item['column'];

                switch ($summary) {
                    case 'Min':
                        $label = $item['column'] . "_min";
                        $columns[] = DB::raw("MIN({$column}) as {$label}");
                        break;
                    case 'Max':
                        $label = $item['column'] . "_max";
                        $columns[] = DB::raw("MAX({$column}) as {$label}");
                        break;
                    case 'Sum':
                        $label = $item['column'] . "_sum";
                        $columns[] = DB::raw("SUM({$column}) as {$label}");
                        break;
                    case 'Median':
                        $label = $item['column'] . "_median";
                        $columns[] = DB::raw("PERCENTILE_CONT(0.5) WITHIN GROUP (ORDER BY {$column}) AS {$label}");
                        break;
                }
            }

            foreach ($select['complex'] as $item) {
                $column = "s1." . $item['column'];

                $date = $item['date'];

                $where = is_array($date)
                    ? "s1.period_type='quarter' AND s1.year={$date[0]} AND s1.quarter={$date[1]}"
                    : "s1.period_type='annual' AND s1.year={$date}";

                switch ($summary) {
                    case 'Min':
                        $label = $item['accessor'] . "_min";
                        $columns[] = DB::raw("MIN({$column}) FILTER (WHERE {$where}) as {$label}");
                        break;
                    case 'Max':
                        $label = $item['accessor'] . "_max";
                        $columns[] = DB::raw("MAX({$column}) FILTER (WHERE {$where}) as {$label}");
                        break;
                    case 'Sum':
                        $label = $item['accessor'] . "_sum";
                        $columns[] = DB::raw("SUM({$column}) FILTER (WHERE {$where}) as {$label}");
                        break;
                    case 'Median':
                        $label = $item['accessor'] . "_median";
                        $columns[] = DB::raw("PERCENTILE_CONT(0.5) WITHIN GROUP (ORDER BY {$column}) FILTER (WHERE {$where}) AS {$label}");
                        break;
                }
            }
        }

        return (array) $query
            ->select($columns)
            ->join('standardized_new as s1', 's.ticker', '=', 's1.ticker')
            ->first();
    }

    public static function findEachCriteriaCount(array $universal, array $financial)
    {
        $count = [
            'financial' => [],
        ];

        $universal = collect($universal)->filter(fn($item) => count($item['data'] ?? []))->toArray();

        $query = DB::connection('pgsql-xbrl')->table('company_profile as c')->join('standardized_new as s', 'c.symbol', '=', 's.ticker');

        if (count(array_keys($universal))) {
            $count['universal'] = static::applyUniversalCriteria($query->clone(), $universal)->count(DB::raw('DISTINCT c.symbol'));
        }

        foreach ($financial as $item) {
            if ($item['operator'] === 'display') continue;

            $count['financial'][$item['id']] = static::applyFinancialCriteria($query->clone(), [$item])->count(DB::raw('DISTINCT c.symbol'));
        }

        return $count;
    }

    private static function applyUniversalCriteria(Builder $query, array $criterias)
    {
        $criterias = collect($criterias)->filter(fn($item) => count($item['data'] ?? []))->toArray();

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
            })
            ->when(isset($criterias['market_cap']), function ($query) use ($criterias) {
                $value = $criterias['market_cap']['data'];

                $billion = 1000000000;

                if ($criterias['market_cap']['exclude']) {
                    if (is_numeric($value[0])) {
                        $query->where('c.market_cap', '<', $value[0] * $billion);
                    }

                    if (is_numeric($value[1])) {
                        $query->where('c.market_cap', '>', $value[1] * $billion);
                    }

                    return $query;
                }

                if (is_numeric($value[0])) {
                    $query->where('c.market_cap', '>=', $value[0] * $billion);
                }

                if (is_numeric($value[1])) {
                    $query->where('c.market_cap', '<=', $value[1] * $billion);
                }

                return $query;
            });
    }

    private static function applyFinancialCriteria(Builder $query_, array $criterias)
    {
        $options = static::options(true);

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

                    $query->whereIn('s.year', $dates);
                } else {
                    $dates = collect(($criteria['dates'] ?? []))
                        ->map(function ($date) {
                            [$quarter, $year] = explode(' ', $date);

                            return [intval($year), intval(ltrim($quarter, 'Q'))];
                        })
                        ->toArray();

                    $query->where(function ($q) use ($dates) {
                        foreach ($dates as $date) {
                            $q->orWhere(fn($q1) => $q1->where('s.year', $date[0])->where('s.quarter', $date[1]));
                        }
                    });
                }

                $query->whereNotNull($column);

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

                    case 'between':
                        $query->where($column, '>=', $criteria['value'][0])->where($column, '<=', $criteria['value'][1]);
                        break;

                    default:
                        break;
                }
            };

            if ($criteria['operator'] !== 'display') {
                $query_->where($where);
            }
        }

        return $query_;
    }

    public static function resolveValidCriterias(array $universalCriteria_, array $financialCriteria_)
    {
        $universalCriteria = [];
        foreach (['locations', 'stock_exchanges', 'industries', 'sectors', 'market_cap'] as $key) {
            if (count(data_get($universalCriteria_, $key . '.data') ?? []) || data_get($universalCriteria_, $key . '.displayOnly')) {
                $universalCriteria[$key] = $universalCriteria_[$key];
            }
        }

        $financialCriteria = [];
        foreach ($financialCriteria_ as $criteria) {
            if (
                $criteria['metric'] && $criteria['type'] && $criteria['period'] && count($criteria['dates']) && $criteria['operator']
                // if operator is between, then value should be an array with two elements else it should be a single value
                && (
                    $criteria['operator'] === 'display' ||
                    ($criteria['operator'] === 'between'
                        ? (data_get($criteria, 'value.0') && data_get($criteria, 'value.1'))
                        : data_get($criteria, 'value'))
                )
            ) {
                $financialCriteria[] = $criteria;
            }
        }

        return [
            'universal' => $universalCriteria,
            'financial' => $financialCriteria,
        ];
    }

    public static function dataDateRange()
    {
        $cacheKey = 'screener_min_dates';
        $dates = Cache::remember(
            $cacheKey,
            now()->addDay(),
            fn() => DB::connection('pgsql-xbrl')
                ->table('standardized_new')
                ->select('period_type', DB::raw('min(year) as year'))
                ->groupBy('period_type')
                ->pluck('year', 'period_type')
        );

        $currentYear = Carbon::now()->year;

        return [
            'annual' => static::generateAnnualDates($dates['annual'] ?? $currentYear),
            'quarter' => static::generateQuarterlyDates($dates['quarter'] ?? $currentYear),
        ];
    }

    private static function generateAnnualDates(int $startYear)
    {
        $dates = [];
        $currentYear = Carbon::now()->year;

        for ($i = $startYear; $i <= $currentYear; $i++) {
            $dates[] = 'FY ' . $i;
        }

        return array_reverse($dates);
    }

    private static function generateQuarterlyDates(int $startYear)
    {
        $dates = [];
        $currentYear =  Carbon::now()->year;

        for ($i = $startYear; $i < $currentYear; $i++) {
            $dates[] = 'Q1 ' . $i;
            $dates[] = 'Q2 ' . $i;
            $dates[] = 'Q3 ' . $i;
            $dates[] = 'Q4 ' . $i;
        }

        $currentQuarter = Carbon::now()->quarter;

        foreach (range(1, $currentQuarter) as $quarter) {
            $dates[] = 'Q' . $quarter . ' ' . $currentYear;
        }

        return array_reverse($dates);
    }
}
