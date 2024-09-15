<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use App\Models\InfoTikrPresentation;
use Illuminate\Support\Facades\Cache;

class TableBuilderService
{
    public static $options = null;

    public static function options($flattened = false)
    {
        if (!self::$options) {
            self::$options = [];

            foreach (config('capitalyze.standardized_metrics') as $option) {
                $item = [
                    'title' => $option['title'],
                ];

                if ($option['has_children']) {
                    $item['items'] = collect(array_values($option['items']))->flatten(1);
                } else {
                    $item['items'] = $option['items'];
                }

                self::$options[] = $item;
            }
        }

        $options = self::$options;

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

    public static function resolveData($companies)
    {
        if (!count($companies)) {
            return [
                'data' => [],
                'dates' => [],
            ];
        }

        $_companies = $companies;
        sort($_companies);

        $cacheKey = 'table_builder_' . md5(implode(',', $_companies));

        return Cache::remember(
            $cacheKey,
            3600,
            function () use ($companies) {
                $data = array_reduce($companies, function ($d, $j) {
                    $d[$j] = [];
                    return $d;
                }, []);

                $columns = ['income_statement', 'balance_sheet', 'cash_flow', 'ratios'];

                $periods = ['annual', 'quarter'];

                $datePlaceholders = array_reduce($columns, function ($c, $i) {
                    $c[$i] = [];
                    return $c;
                }, []);

                $dates = array_reduce($periods, function ($p, $i) use ($datePlaceholders) {
                    $p[$i] = $datePlaceholders;
                    return $p;
                }, []);

                $standardData = InfoTikrPresentation::query()
                    ->whereIn('ticker', $companies)
                    ->whereIn('period', $periods)
                    ->select(['ticker', 'period', ...$columns])
                    ->get()
                    ->groupBy('period');

                foreach ($standardData as $period => $items) {
                    $min = now()->year;
                    $max = 0;

                    foreach ($items as $item) {
                        foreach ($columns as $column) {
                            $json = json_decode($item->{$column}, true);

                            foreach ($json as $key => $_value) {
                                $key = explode('|', $key)[0];

                                $value = [];

                                foreach ($_value as $date => $v) {
                                    $date = Carbon::parse($date);

                                    $min = $date->year < $min ? $date->year : $min;
                                    $max = $date->year > $max ? $date->year : $max;

                                    $v_key = $period === 'quarter'
                                        ? 'Q' . $date->quarter . ' ' . $date->year
                                        : 'FY ' . $date->year;

                                    $val = explode('|', $v[0])[0];
                                    $value[$v_key] = is_numeric($val) ? round((float) $val, 3) : null;
                                }

                                $dates[$period][$column] = array_unique(array_merge($dates[$period][$column], array_keys($value)));

                                $key = $column . '||' . $key;

                                $data[$item->ticker][$key] = array_merge(
                                    $data[$item->ticker][$key] ?? [],
                                    $value
                                );
                            }
                        }
                    }

                    // sort companies by order
                    uksort($data, fn($a, $b) => array_search($a, $companies) - array_search($b, $companies));
                }

                return [
                    'data' => $data,
                    'dates' => $dates,
                ];
            }
        );
    }
}
