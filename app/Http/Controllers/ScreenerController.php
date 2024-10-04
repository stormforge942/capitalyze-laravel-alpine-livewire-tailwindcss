<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class ScreenerController extends Controller
{
    public function show(Request $request)
    {
        $ticker = $request->query('ticker', Company::DEFAULT_TICKER);

        $company = Company::where('ticker', $ticker)->get()->first();

        return view('layouts.company', ['company' => $company, 'tab' => 'screener']);
    }
}
