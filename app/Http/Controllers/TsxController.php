<?php

namespace App\Http\Controllers;

use App\Models\Tsx;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class TsxController extends BaseController
{
    public function metrics(Request $request, $ticker)
    {
        return view('layouts.stock-exchange', [
            'model' => Tsx::where('symbol', $ticker)->get()->first(),
            'period' => $request->query('period', 'annual'),
            'exchange' => 'tsx',
            'tab' => 'metrics'
        ]);
    }

    public function profile(Request $request, $ticker){
        return view('layouts.stock-exchange', [
            'model' => Tsx::where('symbol', $ticker)->first(),
            'period' => $request->query('period', 'annual'),
            'exchange' => 'tsx',
            'tab' => 'profile'
        ]);

    }

    public function filings(Request $request, $ticker)
    {
        return view('layouts.stock-exchange', [
            'model' => Tsx::where('symbol', $ticker)->get()->first(),
            'period' => $request->query('period', 'annual'),
            'exchange' => 'tsx',
            'tab' => 'filings'
        ]);
    }
}
