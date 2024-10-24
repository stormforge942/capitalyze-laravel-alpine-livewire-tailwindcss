<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Services\ScreenerTableBuilderService;

class ScreenerController extends Controller
{
    public function show(Request $request)
    {
        $ticker = $request->query('ticker', Company::DEFAULT_TICKER);

        $company = Company::where('ticker', $ticker)->get()->first();

        return view('layouts.company', ['company' => $company, 'tab' => 'screener']);
    }

    public function criteriaResultCount(Request $request)
    {
        $result = ScreenerTableBuilderService::findEachCriteriaCount($request->input('universal'), $request->input('financial'));

        return response()->json($result);
    }
}
