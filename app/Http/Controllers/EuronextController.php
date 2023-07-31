<?php

namespace App\Http\Controllers;

use App\Models\Euronext;
use Illuminate\Routing\Controller as BaseController;

class EuronextController extends BaseController
{
    public function metrics($ticker)
    {
        $euronext = Euronext::where('symbol', $ticker)->get()->first();

        return view('layouts.euronext', [
            'euronext' => $euronext,
            'tab' => 'metrics'
        ]);
    }
}
