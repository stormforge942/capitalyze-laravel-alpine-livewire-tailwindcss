<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class CompanyController extends BaseController
{
    public function show(Request $request, $ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('company.show', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period') || 'annual'
        ]);
    }

    public function metrics(Request $request, $ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('company.metrics', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period') || 'annual'
        ]);
    }

    public function calcbench(Request $request, $ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('company.calcbench', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period') || 'annual'
        ]);
    }

    public function report(Request $request, $ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('company.report', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period') || 'annual'
        ]);
    }

    public function periods(Request $request, $ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('company.periods', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period') || 'annual'
        ]);
    }

    public function sc2(Request $request, $ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('company.sc2', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period') || 'annual'
        ]);
    }

    public function sc3(Request $request, $ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('company.sc3', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period') || 'annual'
        ]);
    }
}
