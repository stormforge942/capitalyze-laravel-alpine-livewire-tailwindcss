<?php

namespace App\Http\Controllers;

use App\Models\Etf;
use Illuminate\Routing\Controller as BaseController;

class EtfController extends BaseController
{
    public function holdings($cik, $etf_symbol)
    {
        return view('layouts.etf', [
            'etf' => Etf::query()
                ->where('cik', $cik)
                ->where('etf_symbol', $etf_symbol)
                ->firstOrFail(),
            'tab' => 'holdings'
        ]);
    }

    public function returns($cik, $etf_symbol)
    {
        return view('layouts.etf', [
            'etf' => Etf::query()
                ->where('cik', $cik)
                ->where('etf_symbol', $etf_symbol)
                ->firstOrFail(),
            'tab' => 'returns'
        ]);
    }
}
