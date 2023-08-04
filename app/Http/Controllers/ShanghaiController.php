<?php

namespace App\Http\Controllers;

use App\Models\Shanghai;
use Illuminate\Routing\Controller as BaseController;

class ShanghaiController extends BaseController
{
    public function metrics($ticker)
    {
        $shanghai = Shanghai::where('symbol', $ticker)->get()->first();

        return view('layouts.shanghai', [
            'shanghai' => $shanghai,
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
