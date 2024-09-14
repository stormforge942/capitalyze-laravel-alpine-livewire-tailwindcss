<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\ScreenerTab;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Livewire\Screener\Page;

class ScreenerController extends Controller
{
    public function show(Request $request)
    {
        $ticker = $request->query('ticker', Company::DEFAULT_TICKER);

        $company = Company::where('ticker', $ticker)->get()->first();

        return view('layouts.company', ['company' => $company, 'tab' => 'screener']);
    }

    public function update(Request $request, ScreenerTab $tab)
    {
        $attributes = $request->validate([
            ...($request->has('universal_criteria') ? [
                'universal_criteria' => ['nullable', 'array'],
                'universal_criteria.locations.exclude' => ['required', 'boolean'],
                'universal_criteria.locations.data' => ['nullable', 'array'],
                'universal_criteria.locations.data.*' => ['string'],
                'universal_criteria.stock_exchanges.exclude' => ['required', 'boolean'],
                'universal_criteria.stock_exchanges.data' => ['nullable', 'array'],
                'universal_criteria.stock_exchanges.data.*' => ['string'],
                'universal_criteria.sectors.exclude' => ['required', 'boolean'],
                'universal_criteria.sectors.data' => ['nullable', 'array'],
                'universal_criteria.sectors.data.*' => ['string'],
                'universal_criteria.industries.exclude' => ['required', 'boolean'],
                'universal_criteria.industries.data' => ['nullable', 'array'],
                'universal_criteria.industries.data.*' => ['string'],
                'universal_criteria.market_cap' => ['required', 'array', 'min:2', 'max:2'],
                'universal_criteria.market_cap.*' => ['nullable', 'numeric'],
            ] : []),

            ...($request->has('financial_criteria') ? [
                'financial_criteria' => ['nullable', 'array'],
                'financial_criteria.*' => ['array'],
                'financial_criteria.*.metric' => ['nullable', 'string'],
                'financial_criteria.*.type' => ['nullable', Rule::in(['value', 'changeYoY'])],
                'financial_criteria.*.period' => ['nullable', Rule::in(['annual', 'quarterly'])],
                'financial_criteria.*.dates' => ['nullable', 'array'],
                'financial_criteria.*.dates.*' => ['required', 'string'],
                'financial_criteria.*.operator' => ['nullable', Rule::in(array_keys(Page::OPERATORS))],
                'financial_criteria.*.value' => ['nullable'],
            ] : []),

            ...($request->has('summaries') ? [
                'summaries' => ['nullable', 'array'],
                'summaries.*' => ['required', Rule::in(Page::SUMMARIES)],
            ] : []),
        ]);

        if (isset($attributes['financial_criteria'])) {
            $where = fn($criteria) => !empty($criteria['metric']) && !empty($criteria['type'] && !empty($criteria['period']) && !empty($criteria['dates']));

            $attributes['financial_criteria'] = collect($attributes['financial_criteria'])
                ->filter($where)
                ->map(fn($item) => [
                    ...$item,
                    'id' => Str::uuid()->toString(),
                ])
                ->values()
                ->toArray();
        }


        $tab->update($attributes);

        return response()->json(['message' => 'Success']);
    }
}
