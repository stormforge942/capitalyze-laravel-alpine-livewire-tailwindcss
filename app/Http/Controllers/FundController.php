<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use Illuminate\Routing\Controller as BaseController;

class FundController extends BaseController
{
    public function summary($cik)
    {
        $fund = Fund::where('cik', $cik)->get()->first();

        return view('layouts.fund', [
            'fund' => $fund,
            'cik' => $cik,
            'tab' => 'summary'
        ]);
    }

    public function holdings($cik)
    {
        $fund = Fund::where('cik', $cik)->get()->first();

        return view('layouts.fund', [
            'fund' => $fund,
            'cik' => $cik,
            'tab' => 'holdings'
        ]);
    }

    public function metrics($cik)
    {
        $fund = Fund::where('cik', $cik)->get()->first();

        return view('layouts.fund', [
            'fund' => $fund,
            'cik' => $cik,
            'tab' => 'metrics'
        ]);
    }

    public function insider($cik)
    {
        $fund = Fund::where('cik', $cik)->get()->first();

        return view('layouts.fund', [
            'fund' => $fund,
            'cik' => $cik,
            'tab' => 'insider'
        ]);
    }

    public function filings($cik)
    {
        $fund = Fund::where('cik', $cik)->get()->first();

        return view('layouts.fund', [
            'fund' => $fund,
            'cik' => $cik,
            'tab' => 'filings'
        ]);
    }

    public function restatement($cik)
    {
        $fund = Fund::where('cik', $cik)->get()->first();

        return view('layouts.fund', [
            'fund' => $fund,
            'cik' => $cik,
            'tab' => 'restatement'
        ]);
    }
}
