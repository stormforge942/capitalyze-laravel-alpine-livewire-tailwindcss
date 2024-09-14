<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Livewire\Screener\Page;
use App\Models\ScreenerTab;

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
            'universal_criteria' => ['sometimes', 'nullable', 'array'],
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

            'financial_criteria' => ['sometimes', 'nullable', 'array'],
            'financial_criteria.*' => ['array'],
            'financial_criteria.*.metric' => ['required', 'string'],
            'financial_criteria.*.type' => ['required', Rule::in(['value', 'changeYoY'])],
            'financial_criteria.*.period' => ['required', 'string'],
            'financial_criteria.*.operator' => ['required', Rule::in(['>', '>=', '=', '<', '<=', 'between'])],
            'financial_criteria.*.value' => ['required'],

            'summaries' => ['sometimes', 'nullable', 'array'],
            'summaries.*' => ['required', Rule::in(Page::SUMMARIES)],
        ]);

        $tab->update($attributes);

        return response()->json(['message' => 'Success']);
    }
}
