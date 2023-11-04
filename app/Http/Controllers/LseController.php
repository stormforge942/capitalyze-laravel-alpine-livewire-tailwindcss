<?php

namespace App\Http\Controllers;

use App\Models\Lse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class LseController extends BaseController
{
    public function metrics(Request $request, $ticker)
    {
        return view('layouts.stock-exchange', [
            'model' => Lse::where('symbol', $ticker)->get()->first(),
            'period' => $request->query('period', 'annual'),
            'exchange' => 'lse',
            'tab' => 'metrics'
        ]);
    }

    public function filings(Request $request, $ticker)
    {
        return view('layouts.stock-exchange', [
            'model' => Lse::where('symbol', $ticker)->get()->first(),
            'period' => $request->query('period', 'annual'),
            'exchange' => 'lse',
            'tab' => 'filings'
        ]);
    }

    public function profile(Request $request, $ticker)
    {
        return view('layouts.stock-exchange', [
            'model' => Lse::where('symbol', $ticker)->get()->first(),
            'period' => $request->query('period', 'annual'),
            'exchange' => 'lse',
            'tab' => 'profile'
        ]);
    }
}
