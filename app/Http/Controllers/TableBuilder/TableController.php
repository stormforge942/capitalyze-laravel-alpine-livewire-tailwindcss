<?php

namespace App\Http\Controllers\TableBuilder;

use App\Http\Controllers\Controller;
use App\Models\CompanyTableComparison;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class TableController extends Controller
{
    public function update(Request $request, CompanyTableComparison $table)
    {
        $attributes = $request->validate([
            'summaries' => ['sometimes', 'required', 'array'],
            'summaries.*' => ['string', Rule::in(config('capitalyze.table-builder.summaries'))],
            'metrics' => ['sometimes', 'nullable', 'array'],
            'settings' => ['sometimes', 'required', 'array'],
            'settings.decimalPlaces' => ['integer', 'min:0'],
            'settings.unit' => ['string', Rule::in(config('capitalyze.unitTypes'))],
        ]);

        $table->update($attributes);

        return response('Success');
    }

    public function updateNote(Request $request, CompanyTableComparison $table)
    {
        $request->validate([
            'company' => ['required', 'string'],
            'note' => ['nullable', 'string'],
        ]);

        $notes = $table->notes;

        $notes[$request->company] = $request->note;

        $table->update(['notes' => Arr::only($notes, $table->companies)]);

        return response('Success');
    }

    public function updateTableOrder(Request $request, CompanyTableComparison $table)
    {
        $request->validate([
            'data_rows' => ['nullable', 'array'],
            'data_rows.*' => ['string'],
        ]);

        $order = $table->table_order;

        if ($request->data_rows) {
            $order['data_rows'] = $request->data_rows;
        }

        $table->update(['table_order' => $order]);

        return response('Success');
    }
}
