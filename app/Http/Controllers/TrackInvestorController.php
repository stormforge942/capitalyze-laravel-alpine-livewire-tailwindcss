<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class TrackInvestorController extends Controller
{
    public function __invoke(Request $request)
    {
        $ticker = $request->query('ticker', Company::DEFAULT_TICKER);

        $company = Company::where('ticker', $ticker)->get()->first();

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'track-investor'
        ]);
    }
}
