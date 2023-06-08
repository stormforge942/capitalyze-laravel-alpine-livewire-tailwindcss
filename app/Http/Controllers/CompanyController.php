<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class CompanyController extends BaseController
{
    public function geographic(Request $request, $ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'geographical'
        ]);
    }

    public function product(Request $request, $ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'products'
        ]);
    }

    public function metrics(Request $request, $ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'metrics'
        ]);
    }

    public function report(Request $request, $ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'report'
        ]);
    }

    public function shareholders(Request $request, $ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'shareholders'
        ]);
    }

    public function summary(Request $request, $ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'summary'
        ]);
    }

    public function filings(Request $request, $ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'filings'
        ]);
    }

    public function insider(Request $request, $ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'insider'
        ]);
    }

    public function restatement(Request $request, $ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'restatement'
        ]);
    }
}
