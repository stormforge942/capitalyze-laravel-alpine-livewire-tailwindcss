<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class MutualFundsSummaryGenerator
{
    public function __construct(private array $funds)
    {
    }

    public function generate(): array
    {
        $latestFilings = DB::connection('pgsql-xbrl')
            ->table('mutual_fund_holdings_summary')
            ->whereIn('fund_symbol', array_keys($this->funds))
            ->where('is_latest', true)
            ->select('fund_symbol', 'date');

        $filings = DB::connection('pgsql-xbrl')
            ->table('mutual_fund_holdings as filings')
            ->joinSub($latestFilings, 'latest', function ($join) {
                $join->on('filings.fund_symbol', '=', 'latest.fund_symbol')
                    ->on('filings.period_of_report', '=', 'latest.date');
            })
            ->select([
                'filings.name', 'filings.symbol', 'filings.fund_symbol', 'filings.change_in_balance', 'filings.weight', 'filings.balance', 'filings.previous_weight'
            ])
            ->get()
            ->groupBy('fund_symbol');

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

        foreach ($filings as $symbol => $group) {
            $topBuy = $group->where('change_in_balance', '>', 0)
                ->sortByDesc('period_of_report')
                ->first();

            if (!$topBuy) continue;

            $topBuys[] = [
                'fund_name' => Str::title($this->funds[$symbol]) . ' (' . $symbol . ')',
                'symbol' => $topBuy->symbol,
                'company' => Str::title($topBuy->name) . ' (' . $topBuy->symbol . ')',
                'change' => $topBuy->change_in_balance,
                'formatted_change' => number_format(abs($topBuy->change_in_balance)),
                'weight' => $topBuy->weight,
                'formatted_weight' => round($topBuy->weight, 3),
                'value' => $topBuy->balance,
                'formatted_value' => number_format($topBuy->balance / 1000000),
            ];
        }

        return $topBuys;
    }

    private function findFundsTopSells($filings)
    {
        $topSells = [];

        foreach ($filings as $symbol => $group) {
            $topSell = $group->where('change_in_balance', '<', 0)
                ->sortByDesc('period_of_report')
                ->first();

            if (!$topSell) continue;

            $topSells[] = [
                'fund_name' => Str::title($this->funds[$symbol]) . ' (' . $symbol . ')',
                'symbol' => $topSell->symbol,
                'company' => Str::title($topSell->name) . ' (' . $topSell->symbol . ')',
                'change' => $topSell->change_in_balance,
                'formatted_change' => number_format(abs($topSell->change_in_balance)),
                'weight' => $topSell->weight,
                'formatted_weight' => round($topSell->weight, 3),
                'value' => $topSell->balance,
                'formatted_value' => number_format($topSell->balance / 1000000),
            ];
        }

        return $topSells;
    }

    private function findFundsNewBuys($filings)
    {
        $newBuys = [];

        foreach ($filings as $symbol => $group) {
            $_newBuys = $group->where('last_weight', 0)->sortByDesc('period_of_report');

            $fundName = Str::title($this->funds[$symbol]) . ' (' . $symbol . ')';

            foreach ($_newBuys as $newBuy) {
                $newBuys[] = [
                    'fund_name' => $fundName,
                    'symbol' => $newBuy->symbol,
                    'company' => Str::title($newBuy->name) . ' (' . $newBuy->symbol . ')',
                    'change' => $newBuy->change_in_balance,
                    'formatted_change' => number_format(abs($newBuy->change_in_balance)),
                    'weight' => $newBuy->weight,
                    'formatted_weight' => round($newBuy->weight, 3),
                    'value' => $newBuy->balance,
                    'formatted_value' => number_format($newBuy->balance / 1000000, 3),
                ];
            }
        }

        return $newBuys;
    }

    private function findFundsTopHoldings($filings)
    {
        $holdings = [];

        foreach ($filings as $symbol => $group) {
            $topHolding = $group->where('weight', '>', 0)->sortByDesc('weight')->first();

            if (!$topHolding) continue;

            $holdings[] = [
                'fund_name' => Str::title($this->funds[$symbol]) . ' (' . $symbol . ')',
                'symbol' => $topHolding->symbol,
                'company' => Str::title($topHolding->name) . ' (' . $topHolding->symbol . ')',
                'change' => $topHolding->change_in_balance,
                'formatted_change' => number_format(abs($topHolding->change_in_balance)),
                'weight' => $topHolding->weight,
                'formatted_weight' => round($topHolding->weight, 3),
                'value' => $topHolding->balance,
                'formatted_value' => number_format($topHolding->balance / 1000000),
            ];
        }

        return $holdings;
    }
}
