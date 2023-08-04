<?php

namespace App\Http\Controllers;

use App\Models\Lse;
use Illuminate\Routing\Controller as BaseController;

class LseController extends BaseController
{
    public function metrics($ticker)
    {
        $lse = Lse::where('symbol', $ticker)->get()->first();

        return view('layouts.lse', [
            'lse' => $lse,
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
