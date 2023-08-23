<?php

namespace App\Http\Controllers;

use App\Models\Lse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class LseController extends BaseController
{
    public function metrics(Request $request, $ticker)
    {
        $lse = Lse::where('symbol', $ticker)->get()->first();

        return view('layouts.lse', [
            'lse' => $lse,
            'period' => $request->query('period', 'annual'),
            'tab' => 'metrics'
        ]);
    }

    public function filings($ticker)
    {
        $lse = Lse::where('symbol', $ticker)->get()->first();

        return view('layouts.lse', [
            'lse' => $lse,
            'tab' => 'filings'
        ]);
    }
}
