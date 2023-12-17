<?php

namespace App\Http\Controllers;

use App\Models\Company;

class EarningsCalendarController extends Controller
{
    public function __invoke()
    {
        $company = Company::where('ticker', Company::DEFAULT_TICKER)->get()->first();

        return view('layouts.company', [
            'tab' => 'earnings-calendar',
            'company' => $company,
        ]);
    }
}
