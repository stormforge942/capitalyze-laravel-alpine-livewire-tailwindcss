<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Routing\Controller as BaseController;

class LseController extends BaseController
{
    public function metrics($ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('layouts.lse', [
            'company' => $company,
            'tab' => 'metrics'
        ]);
    }
}
