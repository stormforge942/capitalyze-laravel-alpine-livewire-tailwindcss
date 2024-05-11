<?php

namespace App\Http\Controllers\TableBuilder;

use App\Http\Controllers\Controller;
use App\Models\CompanyTableComparison;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TableController extends Controller
{
    public function update(Request $request, CompanyTableComparison $table)
    {
        $request->validate([
            'summaries' => ['required', 'array'],
            'summaries.*' => ['string', Rule::in(config('capitalyze.table-builder.summaries'))],
        ]);

        $table->update(['summaries' => $request->summaries]);

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
