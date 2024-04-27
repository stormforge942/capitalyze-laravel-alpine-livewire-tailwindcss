<?php

namespace App\Http\Controllers\Builder;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\CompanyChartComparison;

class ChartController extends Controller
{
    public function update(Request $request, CompanyChartComparison $chart)
    {
        abort_if($chart->user_id !== Auth::id(), 403);

        $attrs = $request->validate([
            'name' => ['sometimes', 'required', 'string'],
            'companies' => ['sometimes', 'required', 'array'],
            'metrics' => ['sometimes', 'required', 'array'],
            'filters' => ['sometimes', 'required', 'array'],
            'metric_attributes' => ['nullable', 'array'],
            'panel' => ['sometimes', 'string'],
        ]);

        $attrs['metric_attributes'] ??= [];

        $chart->update(Arr::only($attrs, [
            'name',
            'companies',
            'metrics',
            'filters',
            'metric_attributes',
            'panel',
        ]));
    }
}
