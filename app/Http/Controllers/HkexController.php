<?php

namespace App\Http\Controllers;

use App\Models\Hkex;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class HkexController extends BaseController
{
    public function metrics(Request $request, $ticker)
    {
        return view('layouts.stock-exchange', [
            'model' => Hkex::where('symbol', $ticker)->get()->first(),
            'period' => $request->query('period', 'annual'),
            'exchange' => 'hkex',
            'tab' => 'metrics'
        ]);
    }

    public function filings(Request $request, $ticker)
    {
        return view('layouts.stock-exchange', [
            'model' => Hkex::where('symbol', $ticker)->get()->first(),
            'period' => $request->query('period', 'annual'),
            'exchange' => 'hkex',
            'tab' => 'filings'
        ]);
    }

    public function profile(Request $request, $ticker)
    {
        return view('layouts.stock-exchange', [
            'model' => Hkex::where('symbol', $ticker)->get()->first(),
            'period' => $request->query('period', 'annual'),
            'exchange' => 'hkex',
            'tab' => 'profile'
        ]);
    }
}
