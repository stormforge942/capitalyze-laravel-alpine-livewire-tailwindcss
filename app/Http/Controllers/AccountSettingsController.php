<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class AccountSettingsController extends Controller
{
    public function index(Request $request)
    {
        $company = Company::where('ticker', request('ticker', Company::DEFAULT_TICKER))->firstOrFail();

        return view('layouts.company', [
            'company' => $company,
            'tab' => 'account-settings',
            'src' => 'admin',
            'subtab' => 'company-information',
        ]);
    }
}
