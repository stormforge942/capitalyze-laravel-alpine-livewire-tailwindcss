<?php

namespace App\Http\Controllers;

use App\Models\Japan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class JapanController extends BaseController
{
    public function metrics(Request $request, $ticker)
    {
        $japan = Japan::where('symbol', $ticker)->get()->first();

        return view('layouts.japan', [
            'japan' => $japan,
            'period' => $request->query('period', 'annual'),
            'tab' => 'metrics'
        ]);
    }

    public function filings($ticker)
    {
        $japan = Japan::where('symbol', $ticker)->get()->first();

        return view('layouts.japan', [
            'japan' => $japan,
            'tab' => 'filings'
        ]);
    }
}
