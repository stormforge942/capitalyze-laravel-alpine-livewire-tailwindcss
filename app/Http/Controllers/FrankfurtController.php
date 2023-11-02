<?php

namespace App\Http\Controllers;

use App\Models\Frankfurt;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class FrankfurtController extends BaseController
{
    public function metrics(Request $request, $ticker)
    {
        $frankfurt = Frankfurt::where('symbol', $ticker)->get()->first();

        return view('layouts.stock-exchange', [
            'model' => $frankfurt,
            'period' => $request->query('period', 'annual'),
            'exchange' => 'frankfurt',
            'tab' => 'metrics',
        ]);
    }

    public function filings(Request $request, $ticker)
    {
        $frankfurt = Frankfurt::where('symbol', $ticker)->get()->first();

        return view('layouts.stock-exchange', [
            'model' => $frankfurt,
            'period' => $request->query('period', 'annual'),
            'exchange' => 'frankfurt',
            'tab' => 'filings'
        ]);
    }

    public function profile(Request $request, $ticker)
    {
        $frankfurt = Frankfurt::where('symbol', $ticker)->get()->first();

        return view('layouts.stock-exchange', [
            'model' => $frankfurt,
            'period' => $request->query('period', 'annual'),
            'exchange' => 'frankfurt',
            'tab' => 'profile'
        ]);
    }
}
