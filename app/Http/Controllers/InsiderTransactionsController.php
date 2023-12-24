<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class InsiderTransactionsController extends Controller
{
    public function __invoke(Request $request)
    {
        $ticker = $request->query('ticker', Company::DEFAULT_TICKER);

        $company = Company::where('ticker', $ticker)->get()->first();

        return view('layouts.company', [
            'tab' => 'insider-transactions',
            'company' => $company,
        ]);
    }
}
