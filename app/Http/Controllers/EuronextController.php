<?php

namespace App\Http\Controllers;

use App\Models\Euronext;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class EuronextController extends BaseController
{
    public function metrics(Request $request, $ticker)
    {
        $euronext = Euronext::where('symbol', $ticker)->get()->first();

        return view('layouts.euronext', [
            'euronext' => $euronext,
            'period' => $request->query('period', 'annual'),
            'tab' => 'metrics'
        ]);
    }

    public function filings($ticker)
    {
        $euronext = Euronext::where('symbol', $ticker)->get()->first();

        return view('layouts.euronext', [
            'euronext' => $euronext,
            'tab' => 'filings'
        ]);
    }
}
