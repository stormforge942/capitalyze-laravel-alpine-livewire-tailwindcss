<?php

namespace App\Http\Controllers;

use App\Models\Company;

class BuilderController extends Controller
{
    public function chart()
    {
        $company = Company::where('ticker', request('ticker', Company::DEFAULT_TICKER))->firstOrFail();

        return view('layouts.company', [
            'company' => $company,
            'tab' => 'builder-chart',
        ]);
    }

    public function table()
    {
        $company = Company::where('ticker', request('ticker', Company::DEFAULT_TICKER))->firstOrFail();

        return view('layouts.company', [
            'company' => $company,
            'tab' => 'builder-table',
        ]);
    }
}
