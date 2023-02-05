<?php

namespace App\Http\Controllers;
use App\Models\Company;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class CompanyController extends BaseController
{
    public function show($ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();
        //ddd($attributes);

        return view('company.show', [
            'company' => $company,
        ]);
    }
}
