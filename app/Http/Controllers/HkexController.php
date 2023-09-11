<?php

namespace App\Http\Controllers;

use App\Models\Hkex;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class HkexController extends BaseController
{
    public function metrics(Request $request, $ticker)
    {
        $hkex = Hkex::where('symbol', $ticker)->get()->first();

        return view('layouts.hkex', [
            'hkex' => $hkex,
            'period' => $request->query('period', 'annual'),
            'tab' => 'metrics'
        ]);
    }

    public function filings(Request $request, $ticker)
    {
        $hkex = Hkex::where('symbol', $ticker)->get()->first();

        return view('layouts.hkex', [
            'hkex' => $hkex,
            'period' => $request->query('period', 'annual'),
            'tab' => 'filings'
        ]);
    }
}
