<?php

namespace App\Http\Controllers;

use App\Models\Shanghai;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ShanghaiController extends BaseController
{
    public function metrics(Request $request, $ticker)
    {
        return view('layouts.stock-exchange', [
            'model' => Shanghai::where('symbol', $ticker)->get()->first(),
            'period' => $request->query('period', 'annual'),
            'exchange' => 'shanghai',
            'tab' => 'metrics'
        ]);
    }

    public function filings(Request $request, $ticker)
    {
        return view('layouts.stock-exchange', [
            'model' => Shanghai::where('symbol', $ticker)->get()->first(),
            'period' => $request->query('period', 'annual'),
            'exchange' => 'shanghai',
            'tab' => 'filings'
        ]);
    }

    public function profile(Request $request, $ticker)
    {
        return view('layouts.stock-exchange', [
            'model' => Shanghai::where('symbol', $ticker)->get()->first(),
            'period' => $request->query('period', 'annual'),
            'exchange' => 'shanghai',
            'tab' => 'profile'
        ]);
    }
}
