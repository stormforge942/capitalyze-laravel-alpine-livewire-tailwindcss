<?php

namespace App\Http\Controllers;

use App\Models\Frankfurt;
use App\Models\Otc;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class FrankfurtController extends BaseController
{
    public function metrics(Request $request, $ticker)
    {
        $frankfurt = Frankfurt::where('symbol', $ticker)->get()->first();

        return view('layouts.stock-exchange', [
            'model' => $frankfurt,
            'component' => 'frankfurt-metrics',
            'period' => $request->query('period', 'annual'),
            'tab' => 'metrics',
        ]);
    }

    public function filings(Request $request, $ticker)
    {
        $otc = Frankfurt::where('symbol', $ticker)->get()->first();

        return view('layouts.otc', [
            'otc' => $otc,
            'period' => $request->query('period', 'annual'),
            'tab' => 'filings'
        ]);
    }
}
