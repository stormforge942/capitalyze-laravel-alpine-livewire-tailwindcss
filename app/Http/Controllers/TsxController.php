<?php

namespace App\Http\Controllers;

use App\Models\Tsx;
use Illuminate\Routing\Controller as BaseController;

class TsxController extends BaseController
{
    public function metrics($ticker)
    {
        $tsx = Tsx::where('symbol', $ticker)->get()->first();

        return view('layouts.tsx', [
            'tsx' => $tsx,
            'tab' => 'metrics'
        ]);
    }

    public function filings($ticker)
    {
        $tsx = Tsx::where('symbol', $ticker)->get()->first();

        return view('layouts.tsx', [
            'tsx' => $tsx,
            'tab' => 'filings'
        ]);
    }
}
