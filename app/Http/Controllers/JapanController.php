<?php

namespace App\Http\Controllers;

use App\Models\Japan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class JapanController extends BaseController
{
    public function metrics(Request $request, $ticker)
    {
        return view('layouts.stock-exchange', [
            'model' => Japan::where('symbol', $ticker)->get()->first(),
            'period' => $request->query('period', 'annual'),
            'exchange' => 'japan',
            'tab' => 'metrics'
        ]);
    }

    public function filings(Request $request, $ticker)
    {
        $japan = Japan::where('symbol', $ticker)->get()->first();

        return view('layouts.stock-exchange', [
            'model' => Japan::where('symbol', $ticker)->get()->first(),
            'period' => $request->query('period', 'annual'),
            'exchange' => 'japan',
            'tab' => 'filings'
        ]);
    }
}
