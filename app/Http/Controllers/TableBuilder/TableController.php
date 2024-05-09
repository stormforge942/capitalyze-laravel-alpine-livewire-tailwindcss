<?php

namespace App\Http\Controllers\TableBuilder;

use App\Http\Controllers\Controller;
use App\Models\CompanyTableComparison;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TableController extends Controller
{
    public function __invoke(Request $request, CompanyTableComparison $table)
    {
        $request->validate([
            'summaries' => ['required', 'array'],
            'summaries.*' => ['string', Rule::in(config('capitalyze.table-builder.summaries'))],
        ]);

        $table->update(['summaries' => $request->summaries]);

        return response('Success');
    }
}
