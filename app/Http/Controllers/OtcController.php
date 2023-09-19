<?php

namespace App\Http\Controllers;

use App\Models\Otc;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class OtcController extends BaseController
{
    public function metrics(Request $request, $ticker)
    {
        $otc = Otc::where('symbol', $ticker)->get()->first();

        return view('layouts.otc', [
            'otc' => $otc,
            'period' => $request->query('period', 'annual'),
            'tab' => 'metrics'
        ]);
    }

    public function filings(Request $request, $ticker)
    {
        $otc = Otc::where('symbol', $ticker)->get()->first();

        return view('layouts.otc', [
            'otc' => $otc,
            'period' => $request->query('period', 'annual'),
            'tab' => 'filings'
        ]);
    }
}
