<?php

namespace App\Http\Livewire\TrackInvestor;

use App\Http\Livewire\AsTab;
use App\Models\CompanyFilings;
use App\Models\MutualFundsPage;
use App\Models\TrackInvestorFavorite;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class OverlapMatrix extends Component
{
    use AsTab;

    public $investors;
    public $canLoadMore = true;

    public $category = 'all';
    public $overlapMatrix = [];

    public $loading = true;

    public $page = 1;
    public $limit = 20;

    public $search = '';

    public function mount()
    {
        $this->investors = collect([]);
        $this->getInvestors();
    }

    public function updated($prop)
    {
        if (in_array($prop, ['search'])) {
            $this->page = 1;
            $this->investors = collect([]);
            $this->getInvestors();
        } elseif ($prop === 'category') {
            $this->page = 1;
            $this->investors = collect([]);
            $this->getInvestors();
        }
    }

    private function getInvestors()
    {
        $this->canLoadMore = true;
        $offset = ($this->page - 1) * $this->limit;

        $data = Cache::remember('investors_' . $this->category . '_' . $this->search . '_' . $this->page . '_' . Auth::id(), 300, function () use ($offset) {
            // Initialize favorite identifiers
            $favouriteFunds = TrackInvestorFavorite::where('user_id', Auth::id())
                ->where('type', TrackInvestorFavorite::TYPE_FUND)
                ->pluck('identifier')
                ->toArray();

            $favouriteIdentifiers = TrackInvestorFavorite::where('user_id', Auth::id())
                ->where('type', TrackInvestorFavorite::TYPE_MUTUAL_FUND)
                ->pluck('identifier')
                ->toArray();

            // Set up funds and mutual funds queries
            $fundsQuery = DB::connection('pgsql-xbrl')
                ->table('filings_summary')
                ->select(
                    'investor_name as name',
                    'cik',
                    'total_value',
                    'portfolio_size',
                    'change_in_total_value',
                    'date'
                )
                ->when($this->search, function ($query, $search) {
                    return $query->where('investor_name', 'ilike', '%' . $search . '%');
                })
                ->where('is_latest', true);

            $mutualFundsQuery = DB::connection('pgsql-xbrl')
                ->table('mutual_fund_holdings_summary')
                ->select(
                    'registrant_name as name',
                    'cik',
                    'total_value',
                    'portfolio_size',
                    'change_in_total_value',
                    'fund_symbol',
                    'series_id',
                    'class_id',
                    'class_name',
                    'date'
                )
                ->when($this->search, function ($query, $search) {
                    return $query->where('registrant_name', 'ilike', '%' . $search . '%')
                                ->orWhere('fund_symbol', 'ilike', '%' . $search . '%');
                })
                ->where('is_latest', true);

            // Determine which category to fetch data for
            switch ($this->category) {
                case 'fund':
                    $funds = $fundsQuery->skip($offset)->take($this->limit)->get();
                    $mutualFunds = collect([]);
                    $this->canLoadMore = count($funds) === $this->limit;
                    break;

                case 'mutual_fund':
                    $mutualFunds = $mutualFundsQuery->skip($offset)->take($this->limit)->get();
                    $funds = collect([]);
                    $this->canLoadMore = count($mutualFunds) === $this->limit;
                    break;

                case 'favourite':
                    $funds = $fundsQuery->whereIn('cik', $favouriteFunds)->get();
                    $mutualFunds = $this->getFavouriteMutualFunds($mutualFundsQuery, $favouriteIdentifiers);
                    break;

                default:
                    $funds = $fundsQuery->skip($offset)->take($this->limit)->get();
                    $mutualFunds = $mutualFundsQuery->skip($offset)->take($this->limit)->get();
                    $this->canLoadMore = count($funds) === $this->limit && count($mutualFunds) === $this->limit;
                    break;
            }

            // Get stock counts for funds
            $stockCounts = $this->getStockCountsForFunds($funds);

            // Get stock counts for mutual funds
            $mutualStockCounts = $this->getStockCountsForMutualFunds($mutualFunds);

            // Process funds data
            $this->processFundsData($funds, $favouriteFunds, $stockCounts);

            // Process mutual funds data
            $this->processMutualFundsData($mutualFunds, $favouriteIdentifiers, $mutualStockCounts); 

            return $funds->merge($mutualFunds);
        });

        // Merge the investors data
        $this->investors = $this->investors->merge($data);
        $this->loading = false;
    }

    private function getOverlapMatrix($investors)
    {
        $period = '';

        // Initialize filter arrays
        $mutualFundFilters = [];
        $fundFilters = [];

        // Classify investors into funds and mutual funds
        foreach ($investors as $investor) {
            if ($investor['type'] === 'fund') {
                $fundFilters[] = $investor['cik'];
            } else {
                $mutualFundFilters[] = [
                    'cik' => $investor['cik'],
                    'registrant_name' => $investor['registrant_name'],
                    'fund_symbol' => $investor['fund_symbol'],
                    'series_id' => $investor['series_id'],
                    'class_id' => $investor['class_id'],
                    'class_name' => $investor['class_name'],
                ];
            }
        }

        // Fetch filtered mutual funds data
        $filteredMutualFunds = collect();
        if (count($mutualFundFilters)) {
            $filteredMutualFunds = DB::connection('pgsql-xbrl')
                ->table('mutual_fund_holdings')
                ->select('cik', 'registrant_name as name', 'fund_symbol', 'name as company_name', 'symbol as ticker', 'change_in_balance as change_amount', 'series_id', 'class_id', 'class_name', 'previous_weight as previous', 'price_per_unit as price')
                ->where(function ($query) use($mutualFundFilters) {
                    foreach ($mutualFundFilters as $filter) {
                        $query->orWhere(function ($q) use ($filter) {
                            $q->where('cik', $filter['cik'])
                                ->where('registrant_name', $filter['registrant_name'])
                                ->where('fund_symbol', $filter['fund_symbol'])
                                ->where('series_id', $filter['series_id'])
                                ->where('class_id', $filter['class_id'])
                                ->where('class_name', $filter['class_name']);
                        });
                    }
                })
                ->get();
        }

        // Fetch filtered funds data
        $filteredFunds = collect();
        if (count($fundFilters)) {
            $filteredFunds = DB::connection('pgsql-xbrl')
                ->table('filings')
                ->select('cik', 'investor_name as name', 'name_of_issuer as company_name', 'symbol as ticker', 'change_in_shares as change_amount', 'last_shares as previous', 'price_paid as price', DB::raw('NULL AS fund_symbol'), DB::raw('NULL AS series_id'), DB::raw('NULL AS class_id'), DB::raw('NULL AS class_name'))
                ->whereIn('cik', $fundFilters)
                ->get();
        }

        // Convert collections to arrays
        $combinedData = $filteredMutualFunds->concat($filteredFunds);

        // Group by company_name and count distinct cik values
        $result = $combinedData->groupBy('company_name')
            ->map(function ($companyGroup) {
                $uniqueFunds = $companyGroup->unique(function ($item) {
                    return $item->cik . $item->series_id . $item->class_id . $item->class_name;
                });

                // Avoid calling first() multiple times
                $firstItem = $companyGroup->first();
                $ticker = $firstItem->ticker;
                $companyName = $firstItem->company_name;

                // Use a conditional to fetch price only once
                $price = DB::connection('pgsql-xbrl')
                    ->table('eod_prices')
                    ->select('close')
                    ->where('symbol', strtolower($ticker))
                    ->orderBy('date', 'desc')
                    ->value('close') ?? 0; // Default to 0 if not found

                return [
                    'ticker' => $ticker,
                    'price' => $price,
                    'company_name' => $companyName,
                    'count' => $uniqueFunds->count(),
                    'funds' => $uniqueFunds->values(),
                ];
            });

        $this->overlapMatrix = $result->values()->sortByDesc('count')->groupBy('count');
    }

    private function getFavouriteMutualFunds($mutualFundsQuery, $favouriteIdentifiers)
    {
        if (empty($favouriteIdentifiers)) {
            return collect([]);
        }

        return $mutualFundsQuery->where(function ($query) use ($favouriteIdentifiers) {
            foreach ($favouriteIdentifiers as $identifier) {
                $fund = json_decode($identifier, true);
                $query->orWhere(function ($q) use ($fund) {
                    $q->where('cik', $fund['cik'])
                    ->where('series_id', $fund['series_id'])
                    ->where('class_id', $fund['class_id'])
                    ->where('class_name', $fund['class_name']);
                });
            }
        })->get();
    }

    private function getStockCountsForFunds($funds)
    {
        if ($funds->isEmpty()) {
            return collect();
        }

        $ciks = $funds->pluck('cik')->toArray();
        return DB::connection('pgsql-xbrl')
            ->table('filings as f')
            ->select('f.cik', DB::raw('COUNT(DISTINCT f.name_of_issuer) as stock_count'))
            ->whereIn('f.cik', $ciks)
            ->groupBy('f.cik')
            ->get()
            ->keyBy('cik'); // Key by CIK for easy lookup
    }

    private function getStockCountsForMutualFunds($mutualFunds)
    {
        if ($mutualFunds->isEmpty()) {
            return collect();
        }

        $mutualFilters = $mutualFunds->map(function ($mutualFund) {
            return [
                'cik' => $mutualFund->cik,
                'fund_symbol' => $mutualFund->fund_symbol,
                'series_id' => $mutualFund->series_id,
                'class_id' => $mutualFund->class_id,
            ];
        });

        return DB::connection('pgsql-xbrl')
            ->table('mutual_fund_holdings as mf')
            ->select('mf.cik', 'mf.fund_symbol', 'mf.series_id', 'mf.class_id', DB::raw('COUNT(DISTINCT mf.name) as stock_count'))
            ->where(function ($query) use($mutualFilters) {
                foreach ($mutualFilters as $filter) {
                    $query->orWhere(function ($q) use ($filter) {
                        $q->where('mf.cik', $filter['cik'])
                            ->where('mf.series_id', $filter['series_id'])
                            ->where('mf.class_id', $filter['class_id'])
                            ->where('mf.fund_symbol', $filter['fund_symbol']);
                    });
                }
            })
            ->groupBy('mf.cik', 'mf.fund_symbol', 'mf.series_id', 'mf.class_id')
            ->get()
            ->keyBy(function ($item) {
                return $item->cik . '-' . $item->fund_symbol . '-' . $item->series_id . '-' . $item->class_id;
            });
    }

    private function processFundsData($funds, $favouriteFunds, $stockCounts)
    {
        $funds->transform(function ($fund) use ($favouriteFunds, $stockCounts) {
            $fundArray = (array) $fund;
            $fundArray['type'] = 'fund';
            $fundArray['series_id'] = '';
            $fundArray['class_id'] = '';
            $fundArray['class_name'] = '';
            $fundArray['isFavorite'] = in_array($fundArray['cik'], $favouriteFunds);
            $fundArray['stock_count'] = $stockCounts->get($fundArray['cik'])->stock_count ?? 0;

            return $fundArray;
        });
    }

    private function processMutualFundsData($mutualFunds, $favouriteIdentifiers, $mutualStockCounts)
    {
        $mutualFunds->transform(function ($mutualFund) use ($favouriteIdentifiers, $mutualStockCounts) {
            $fundArray = (array) $mutualFund;
            $fundArray['type'] = 'mutual_fund';

            $id = json_encode([
                'cik' => $fundArray['cik'],
                'registrant_name' => $fundArray['name'],
                'fund_symbol' => $fundArray['fund_symbol'],
                'series_id' => $fundArray['series_id'],
                'class_id' => $fundArray['class_id'],
                'class_name' => $fundArray['class_name'],
            ]);

            $fundArray['isFavorite'] = in_array($id, $favouriteIdentifiers);
            $key = $fundArray['cik'] . '-' . $fundArray['fund_symbol'] . '-' . $fundArray['series_id'] . '-' . $fundArray['class_id'];
            $fundArray['stock_count'] = $mutualStockCounts->get($key)->stock_count ?? 0;

            return $fundArray;
        });
    }

    public function loadMore()
    {
        $this->page++;
        $this->getInvestors();
    }

    public function updateInvestors($investors)
    {
        if (count($investors)) {
            $this->getOverlapMatrix($investors);
        } else {
            $this->overlapMatrix = [];
        }
    }

    public static function title(): string
    {
        return 'Overlap Matrix';
    }

    public function render()
    {
        return view('livewire.track-investor.overlap-matrix');
    }
}
