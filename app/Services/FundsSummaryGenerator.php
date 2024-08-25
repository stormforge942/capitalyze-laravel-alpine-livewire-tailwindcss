<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class FundsSummaryGenerator
{
    public function __construct(private array $funds)
    {
    }

    public function generate(): array
    {
        $latestFilings = DB::connection('pgsql-xbrl')
            ->table('filings_summary')
            ->whereIn('cik', array_keys($this->funds))
            ->where('is_latest', true)
            ->select('cik', 'date');

        $filings = DB::connection('pgsql-xbrl')
            ->table('filings')
            ->joinSub($latestFilings, 'latest', function ($join) {
                $join->on('filings.cik', '=', 'latest.cik')
                    ->on('filings.report_calendar_or_quarter', '=', 'latest.date');
            })
            ->select([
                'filings.cik', 'filings.name_of_issuer', 'filings.symbol', 'filings.change_in_shares_percentage', 'filings.weight', 'filings.value', 'filings.last_shares'
            ])
            ->get()
            ->groupBy('cik');

        return [
            [
                'title' => 'Top Buys',
                'data' => $this->findFundsTopBuys($filings),
            ],
            [
                'title' => 'Top Sells',
                'data' => $this->findFundsTopSells($filings),
            ],
            [
                'title' => 'New Buys',
                'data' => $this->findFundsNewBuys($filings),
            ],
            [
                'title' => 'Top Holdings',
                'data' => $this->findFundsTopHoldings($filings),
            ],
        ];
    }

    private function findFundsTopBuys($filings)
    {
        $topBuys = [];

        foreach ($filings as $cik => $group) {
            $topBuy = $group->where('change_in_shares_percentage', '>', 0)
                ->sortByDesc('change_in_shares_percentage')
                ->first();

            if (!$topBuy) continue;

            $topBuys[] = [
                'fund_name' => $this->funds[$cik],
                'symbol' => $topBuy->symbol,
                'company' => Str::title($topBuy->name_of_issuer),
                'change' => $topBuy->change_in_shares_percentage,
                'formatted_change' => round(abs($topBuy->change_in_shares_percentage), 3) . '%',
                'weight' => $topBuy->weight,
                'formatted_weight' => round($topBuy->weight, 3) . '%',
                'value' => $topBuy->value,
                'formatted_value' => number_format($topBuy->value / 1000000),
            ];
        }

        return $topBuys;
    }

    private function findFundsTopSells($filings)
    {
        $topSells = [];

        foreach ($filings as $cik => $group) {
            $topSell = $group->where('change_in_shares_percentage', '<', 0)
                ->sortBy('change_in_shares_percentage')
                ->first();

            if (!$topSell) continue;

            $topSells[] = [
                'fund_name' => $this->funds[$cik],
                'symbol' => $topSell->symbol,
                'company' => Str::title($topSell->name_of_issuer),
                'change' => $topSell->change_in_shares_percentage,
                'formatted_change' => round(abs($topSell->change_in_shares_percentage), 3) . '%',
                'weight' => $topSell->weight,
                'formatted_weight' => round($topSell->weight, 3) . '%',
                'value' => $topSell->value,
                'formatted_value' => number_format($topSell->value / 1000000),
            ];
        }

        return $topSells;
    }

    private function findFundsNewBuys($filings)
    {
        $newBuys = [];

        foreach ($filings as $cik => $group) {
            $_newBuys = $group->where('last_shares', 0)->sortByDesc('change_in_shares_percentage');

            $fundName = $this->funds[$cik];

            foreach ($_newBuys as $newBuy) {
                $newBuys[] = [
                    'fund_name' => $fundName,
                    'symbol' => $newBuy->symbol,
                    'company' => Str::title($newBuy->name_of_issuer),
                    'change' => $newBuy->change_in_shares_percentage,
                    'formatted_change' => round(abs($newBuy->change_in_shares_percentage), 3) . '%',
                    'weight' => $newBuy->weight,
                    'formatted_weight' => round($newBuy->weight, 3) . '%',
                    'value' => $newBuy->value,
                    'formatted_value' => number_format($newBuy->value / 1000000),
                ];
            }
        }

        return $newBuys;
    }

    private function findFundsTopHoldings($filings)
    {
        $holdings = [];

        foreach ($filings as $cik => $group) {
            $topHolding = $group->where('weight', '>', 0)->sortByDesc('weight')->first();

            if (!$topHolding) continue;

            $holdings[] = [
                'fund_name' => $this->funds[$cik],
                'symbol' => $topHolding->symbol,
                'company' => Str::title($topHolding->name_of_issuer),
                'change' => $topHolding->change_in_shares_percentage,
                'formatted_change' => round(abs($topHolding->change_in_shares_percentage), 3) . '%',
                'weight' => $topHolding->weight,
                'formatted_weight' => round($topHolding->weight, 3) . '%',
                'value' => $topHolding->value,
                'formatted_value' => number_format($topHolding->value / 1000000),
            ];
        }

        return $holdings;
    }
}
