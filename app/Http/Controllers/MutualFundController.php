<?php

namespace App\Http\Controllers;

use App\Models\MutualFunds;
use Illuminate\Routing\Controller as BaseController;

class MutualFundController extends BaseController
{
    public function holdings($cik)
    {
        $fund = MutualFunds::where('cik', $cik)->get()->first();

        return view('layouts.mutual-fund', [
            'fund' => $fund,
            'cik' => $cik,
            'tab' => 'holdings'
        ]);
    }
}
