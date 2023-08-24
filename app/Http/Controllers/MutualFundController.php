<?php

namespace App\Http\Controllers;

use App\Models\MutualFunds;
use Illuminate\Routing\Controller as BaseController;

class MutualFundController extends BaseController
{
    public function holdings($cik, $fund_symbol, $series_id, $class_id)
    {
        $fund = MutualFunds::where('cik', $cik)
        ->where('fund_symbol', $fund_symbol)
        ->where('series_id', $series_id)
        ->where('class_id', $class_id)->get()->first();

        return view('layouts.mutual-fund', [
            'fund' => $fund,
            'cik' => $cik,
            'fund_symbol' => $fund_symbol,
            'series_id' => $series_id,
            'class_id' => $class_id,
            'tab' => 'holdings'
        ]);
    }
}
