<?php

namespace App\Http\Controllers;

use App\Models\Euronext;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class EuronextController extends BaseController
{
    public function metrics(Request $request, $ticker)
    {
        return view('layouts.stock-exchange', [
            'model' => Euronext::where('symbol', $ticker)->get()->first(),
            'period' => $request->query('period', 'annual'),
            'exchange' => 'euronext',
            'tab' => 'metrics'
        ]);
    }

    public function filings(Request $request, $ticker)
    {
        return view('layouts.stock-exchange', [
            'model' => Euronext::where('symbol', $ticker)->get()->first(),
            'period' => $request->query('period', 'annual'),
            'exchange' => 'euronext',
            'tab' => 'filings'
        ]);
    }

    public function profile(Request $request, $ticker)
    {
        return view('layouts.stock-exchange', [
            'model' => Euronext::where('symbol', $ticker)->get()->first(),
            'period' => $request->query('period', 'annual'),
            'exchange' => 'euronext',
            'tab' => 'profile'
        ]);
    }
}
