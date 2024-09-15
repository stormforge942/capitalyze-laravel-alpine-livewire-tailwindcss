<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use App\Models\InfoTikrPresentation;
use Illuminate\Support\Facades\Cache;

class ChartBuilderService
{
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

    public static function resolveData($companies, $metrics, &$metricAttributes = [])
    {
        $metricsMap = self::options(true);
        $periods = ['annual', 'quarter'];

        $data = array_reduce($periods, function ($c, $i) use ($companies) {
            $c[$i] = array_reduce($companies, function ($d, $j) {
                $d[$j] = [];
                return $d;
            }, []);
            return $c;
        }, []);

        $standardKeys = [];
        foreach ($metrics as $metric) {
            [$column, $key] = explode('||', $metric, 2);

            if (!isset($standardKeys[$column])) {
                $standardKeys[$column] = [];
            }

            $standardKeys[$column][] = $key;
        }

        if (empty($standardKeys) || !count($companies)) {
            return null;
        }

        $cacheKey = 'chart_builder_' . md5(implode(',', $companies) . implode(',', array_keys($standardKeys)));

        $standardData = Cache::remember(
            $cacheKey,
            3600,
            fn() => InfoTikrPresentation::query()
                ->whereIn('ticker', $companies)
                ->select(['ticker', 'period', ...array_keys($standardKeys)])
                ->get()
                ->groupBy('period')
        );

        foreach ($standardData as $period => $items) {
            if (!in_array($period, $periods)) {
                continue;
            }

            foreach ($items as $item) {
                foreach ($standardKeys as $column => $keys) {
                    $json = json_decode($item->{$column}, true);

                    foreach ($json as $key => $_value) {
                        $key = explode('|', $key)[0];

                        if (!in_array($key, $keys)) {
                            continue;
                        }

                        $value = [];

                        foreach ($_value as $date => $v) {
                            $val = explode('|', $v[0])[0];
                            $value[$date] = $val ? (float) $val : null;
                        }

                        $key = $column . '||' . $key;

                        if (!isset($metricAttributes[$key])) {
                            $metricAttributes[$key] = [
                                'type' => $metricsMap[$key]['type'] ?? 'bar',
                                'show' => true,
                            ];
                        }

                        $data[$period][$item->ticker][$key] = self::normalizeValue($value, $period);
                    }
                }

                // sort metrics by order
                uksort($data[$period][$item->ticker], fn($a, $b) => array_search($a, $metrics) - array_search($b, $metrics));
            }

            // sort companies by order
            uksort($data[$period], fn($a, $b) => array_search($a, $companies) - array_search($b, $companies));
        }

        $dates = self::extractDates($data);

        $dateRange = [
            'annual' => count($dates['annual']) ? [$dates['annual'][0], $dates['annual'][count($dates['annual']) - 1]] : null,
            'quarter' => count($dates['quarter']) ? [$dates['quarter'][0], $dates['quarter'][count($dates['quarter']) - 1]] : null,
        ];

        foreach ($dateRange as $period => $range) {
            if ($range) {
                $dateRange[$period] = [
                    0 + explode('-', $range[0])[0],
                    0 + explode('-', $range[1])[0],
                ];
            }
        }

        return [
            'data' => $data,
            'dates' => $dates,
            'dateRange' => $dateRange,
        ];
    }

    private static function normalizeValue(array $value, string $period): array
    {
        $val = [];

        foreach ($value as $date => $v) {
            if ($period === 'quarter') {
                $date = Carbon::parse($date)->startOfQuarter();
            } else {
                $date = Carbon::parse($date)->startOfYear();
            }

            $val[$date->toDateString()] = $v;
        }

        return $val;
    }

    private static function extractDates(array $data): array
    {
        $dates = array_reduce(['annual', 'quarter'], function ($c, $i) {
            $c[$i] = [];
            return $c;
        }, []);

        foreach ($data as $period => $item) {
            foreach ($item as $metrics) {
                foreach ($metrics as $values) {
                    $dates[$period] = array_merge($dates[$period], array_keys($values));
                }
            }
        }

        foreach ($dates as $period => $value) {
            $dates[$period] = array_unique($value);
            sort($dates[$period]);
        }

        return $dates;
    }
}
