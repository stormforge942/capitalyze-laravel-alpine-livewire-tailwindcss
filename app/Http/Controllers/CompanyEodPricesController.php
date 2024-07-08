<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CompanyEodPricesController extends Controller
{
    public function __invoke(string $symbol)
    {
        return DB::connection('pgsql-xbrl')
            ->table('eod_prices')
            ->select('date', 'adj_close')
            ->where('symbol', strtolower($symbol))
            ->orderBy('date')
            ->get()
            ->map(function ($price) {
                $date = Carbon::parse($price->date);
                $monthsDiff = now()->diffInMonths($date);

                return [
                    'date' => $price->date,
                    'adj_close' => (float) $price->adj_close,
                    'formatted_value' => number_format($price->adj_close, 4),
                    'periods' => array_values(array_filter([
                        $monthsDiff < 3 ? '3m' : null,
                        $monthsDiff < 6 ? '6m' : null,
                        $monthsDiff <= 12 ? '1yr' : null,
                        $monthsDiff <= (12 * 5) ? '5yr' : null,
                        $date->year == now()->year ? 'ytd' : null,
                        'max',
                    ]))
                ];
            });
    }
}
