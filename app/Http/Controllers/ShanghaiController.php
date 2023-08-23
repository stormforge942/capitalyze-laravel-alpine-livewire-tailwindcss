<?php

namespace App\Http\Controllers;

use App\Models\Shanghai;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ShanghaiController extends BaseController
{
    public function metrics(Request $request, $ticker)
    {
        $shanghai = Shanghai::where('symbol', $ticker)->get()->first();

        return view('layouts.shanghai', [
            'shanghai' => $shanghai,
            'period' => $request->query('period', 'annual'),
            'tab' => 'metrics'
        ]);
    }

    public function filings($ticker)
    {
        $shanghai = Shanghai::where('symbol', $ticker)->get()->first();

        return view('layouts.shanghai', [
            'shanghai' => $shanghai,
            'tab' => 'filings'
        ]);
    }
}
