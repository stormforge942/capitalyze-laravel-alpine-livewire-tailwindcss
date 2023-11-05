<?php

namespace App\Http\Controllers;

use App\Models\Otc;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class OtcController extends BaseController
{
    public function metrics(Request $request, $ticker)
    {
        return view('layouts.stock-exchange', [
            'model' => Otc::where('symbol', $ticker)->get()->first(),
            'period' => $request->query('period', 'annual'),
            'exchange' => 'otc',
            'tab' => 'metrics'
        ]);
    }

    public function filings(Request $request, $ticker)
    {
        return view('layouts.stock-exchange', [
            'model' => Otc::where('symbol', $ticker)->get()->first(),
            'period' => $request->query('period', 'annual'),
            'exchange' => 'otc',
            'tab' => 'filings'
        ]);
    }

    public function profile(Request $request, $ticker)
    {
        return view('layouts.stock-exchange', [
            'model' => Otc::where('symbol', $ticker)->get()->first(),
            'period' => $request->query('period', 'annual'),
            'exchange' => 'otc',
            'tab' => 'profile'
        ]);
    }
}
