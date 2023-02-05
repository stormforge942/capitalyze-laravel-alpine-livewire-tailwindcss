<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Routing\Controller as BaseController;

class CompanyController extends BaseController
{
    public function show($ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('company.show', [
            'company' => $company,
            'ticker' => $ticker
        ]);
    }

    public function metrics($ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('company.metrics', [
            'company' => $company,
            'ticker' => $ticker
        ]);
    }

    public function calcbench($ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('company.calcbench', [
            'company' => $company,
            'ticker' => $ticker
        ]);
    }

    public function report($ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('company.report', [
            'company' => $company,
            'ticker' => $ticker
        ]);
    }

    public function periods($ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('company.periods', [
            'company' => $company,
            'ticker' => $ticker
        ]);
    }

    public function sc2($ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('company.sc2', [
            'company' => $company,
            'ticker' => $ticker
        ]);
    }

    public function sc3($ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('company.sc3', [
            'company' => $company,
            'ticker' => $ticker
        ]);
    }
}
