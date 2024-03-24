<?php

namespace App\Http\Controllers\Builder;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\InfoTikrPresentation;
use Illuminate\Support\Facades\Auth;
use App\Models\CompanyChartComparison;

class ChartController extends Controller
{
    public function show(CompanyChartComparison $chart)
    {
        $periods = ['quarter', 'annual'];

        $data = array_reduce($periods, function ($c, $i) use ($chart) {
            $c[$i] = array_reduce($chart->companies, function ($d, $j) {
                $d[$j] = [];
                return $d;
            }, []);
            return $c;
        }, []);

        $standardKeys = [];
        foreach ($chart->metrics as $metric) {
            [$column, $key] = explode('||', $metric, 2);

            if (!isset($standardKeys[$column])) {
                $standardKeys[$column] = [];
            }

            $standardKeys[$column][] = $key;
        }

        if (empty($standardKeys) || !count($chart->companies)) {
            return [
                'data' => $data,
                'dates' => [],
            ];
        }

        $standardData = InfoTikrPresentation::query()
            ->whereIn('ticker', $chart->companies)
            ->select(['ticker', 'period', ...array_keys($standardKeys)])
            ->get()
            ->groupBy('period');

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
                            $value[$date] = $val ? round((float) $val, 3) : null;
                        }

                        $key = $column . '||' . $key;

                        $data[$period][$item->ticker][$key] = $this->normalizeValue($value, $period);
                    }
                }
            }
        }

        return [
            'data' => $data,
            'dates' => $this->extractDates($data),
        ];
    }

    public function update(Request $request, CompanyChartComparison $chart)
    {
        abort_if($chart->user_id !== Auth::id(), 403);

        $attrs = $request->validate([
            'name' => ['sometimes', 'required', 'string'],
            'companies' => ['sometimes', 'required', 'array'],
            'metrics' => ['sometimes', 'required', 'array'],
            'filters' => ['sometimes', 'required', 'array'],
        ]);

        $chart->update(Arr::only($attrs, ['name', 'companies', 'metrics', 'filters']));
    }

    public function destroy(CompanyChartComparison $chart)
    {
        abort_if($chart->user_id !== Auth::id(), 403);

        $chart->delete();
    }
}
