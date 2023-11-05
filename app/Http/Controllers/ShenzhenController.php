<?php

namespace App\Http\Controllers;

use App\Models\Shenzhen;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ShenzhenController extends BaseController
{
    public function metrics(Request $request, $ticker)
    {
        $shenzhen = Shenzhen::where('symbol', $ticker)->get()->first();

        return view('layouts.stock-exchange', [
            'model' => $shenzhen,
            'period' => $request->query('period', 'annual'),
            'exchange' => 'shenzhen',
            'tab' => 'metrics',
        ]);
    }

    public function filings(Request $request, $ticker)
    {
        $shenzhen = Shenzhen::where('symbol', $ticker)->get()->first();

        return view('layouts.stock-exchange', [
            'model' => $shenzhen,
            'period' => $request->query('period', 'annual'),
            'exchange' => 'shenzhen',
            'tab' => 'filings'
        ]);
    }
}
