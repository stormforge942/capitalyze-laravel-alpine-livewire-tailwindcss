<?php

namespace App\Http\Livewire\TrackInvestor;

use App\Http\Livewire\AsTab;
use App\Models\CompanyFilings;
use App\Models\MutualFundsPage;
use App\Models\TrackInvestorFavorite;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Livewire\Component;

class OverlapMatrix extends Component
{
    use AsTab;

    public $investors;
    public $canLoadMore = true;

    public $category = 'fund';
    public $overlapMatrix = [];

    public $loading = true;

    public $page = 1;
    public $limit = 20;

    public $search = '';

    public $cacheKey;

    public function mount()
    {
        $this->investors = collect([]);
        $this->getInvestors();
        $this->cacheKey = 'overlap_matrix_' . Auth::user()->id;
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

        $data = Cache::remember('investors_' . $this->category . '_' . $this->search . '_' . $this->page . '_' . Auth::id(), $this->category !== 'favourite' ? 300 : 3, function () use ($offset) {
            // Initialize favorite identifiers
            $favorites = TrackInvestorFavorite::where('user_id', Auth::id())
                ->get()
                ->groupBy('type')
                ->mapWithKeys(function ($items, $type) {
                    return [$type => $items->pluck('identifier')->toArray()];
                });

            $favouriteFunds = $favorites->get(TrackInvestorFavorite::TYPE_FUND, []);
            $favouriteMutualFunds = $favorites->get(TrackInvestorFavorite::TYPE_MUTUAL_FUND, []);

            // Set up funds and mutual funds queries
            $fundsQuery = DB::connection('pgsql-xbrl')
                ->table('filings_summary')
                ->select('investor_name as name', 'cik', 'portfolio_size', 'date')
                ->where('is_latest', true)
                ->when($this->search, function ($query, $search) {
                    return $query->where('investor_name', 'ilike', '%' . $search . '%');
                })
                ->orderBy('portfolio_size', 'desc');

            $mutualFundsQuery = DB::connection('pgsql-xbrl')
                ->table('mutual_fund_holdings_summary')
                ->select('registrant_name as name', 'cik', 'portfolio_size', 'fund_symbol', 'series_id', 'class_id', 'class_name', 'date')
                ->where('is_latest', true)
                ->when($this->search, function ($query, $search) {
                    return $query->where('registrant_name', 'ilike', '%' . $search . '%');
                })
                ->orderBy('portfolio_size', 'desc');

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
                    $mutualFunds = $this->getFavouriteMutualFunds($mutualFundsQuery, $favouriteMutualFunds);
                    break;

                default:
                    $funds = $fundsQuery->skip($offset)->take($this->limit)->get();
                    $mutualFunds = $mutualFundsQuery->skip($offset)->take($this->limit)->get();
                    $this->canLoadMore = count($funds) === $this->limit && count($mutualFunds) === $this->limit;
                    break;
            }

            // Process funds data
            $this->processFundsData($funds, $favouriteFunds);

            // Process mutual funds data
            $this->processMutualFundsData($mutualFunds, $favouriteMutualFunds); 

            return $funds->merge($mutualFunds);
        });

        // Merge the investors data
        $this->investors = $this->investors->merge($data);
        $this->loading = false;
    }

    private function getOverlapMatrixData($investors)
    {
        // Initialize filter arrays
        $mutualFundFilters = [];
        $fundFilters = [];

        // Classify investors into funds and mutual funds
        foreach ($investors as $investor) {
            if ($investor['type'] === 'fund') {
                $fundFilters[] = [
                    'cik' => $investor['cik'],
                    'period' => $investor['date'],
                ];
            } else {
                $mutualFundFilters[] = [
                    'cik' => $investor['cik'],
                    'fund_symbol' => $investor['fund_symbol'],
                    'series_id' => $investor['series_id'],
                    'class_id' => $investor['class_id'],
                    'period' => $investor['date'],
                ];
            }
        }

        // Build the base queries
        $mutualFundQuery = $this->buildMutualFundQuery($mutualFundFilters, true);
        $fundQuery = $this->buildFundQuery($fundFilters, true);

        // Combine queries
        $combinedQuery = null;
        if ($mutualFundQuery && $fundQuery) {
            $combinedQuery = $mutualFundQuery->unionAll($fundQuery);
        } elseif ($mutualFundQuery) {
            $combinedQuery = $mutualFundQuery;
        } elseif ($fundQuery) {
            $combinedQuery = $fundQuery;
        }

        // Handle empty combinedQuery case
        $subquery = null;
        if ($combinedQuery) {
            $subquery = DB::connection('pgsql-xbrl')
                ->table(DB::raw("({$combinedQuery->toSql()}) as combined_data"))
                ->mergeBindings($combinedQuery) // Merge bindings for the subquery
                ->select('ticker')
                ->groupBy('ticker')
                ->havingRaw('COUNT(*) >= 2');
        }

        // Build the combined data query
        $combinedDataQuery = DB::connection('pgsql-xbrl')
            ->table(function ($query) use ($mutualFundFilters, $fundFilters) {
                $baseMutualFundQuery = $this->buildMutualFundQuery($mutualFundFilters);
                $baseFundQuery = $this->buildFundQuery($fundFilters);
                
                if ($baseFundQuery && $baseMutualFundQuery) {
                    $baseQuery = $baseMutualFundQuery->unionAll($baseFundQuery);
                } else if ($baseFundQuery) {
                    $baseQuery = $baseFundQuery;
                } else {
                    $baseQuery = $baseMutualFundQuery;
                }
                
                $query->from(DB::raw("({$baseQuery->toSql()}) as combined_data"))
                    ->mergeBindings($baseQuery);
            }, 'combined_data')
            ->when($subquery, function ($query) use ($subquery) {
                // Join the subquery if it exists
                $query->joinSub($subquery, 'filtered_tickers', function ($join) {
                    $join->on('combined_data.ticker', '=', 'filtered_tickers.ticker');
                });
            });

        // Retrieve combined data
        $combinedData = $combinedDataQuery->get();

        $result = $combinedData
            ->groupBy('ticker') // Group the data by 'ticker'
            ->map(function ($companyGroup) {
                // Ensure unique funds based on 'cik', 'series_id', 'class_id', and 'class_name'
                $uniqueFunds = $companyGroup->groupBy(function($item) {
                        return $item->cik . $item->series_id . $item->class_id . $item->class_name;
                    })->map(function($items) {
                        return $items->sortByDesc('change_amount')->first();
                    })->values();

                $firstItem = $companyGroup->first();

                return [
                    'ticker' => $firstItem->ticker,
                    'company_name' => $firstItem->company_name,
                    'count' => $uniqueFunds->count(), // Count of unique funds
                    'funds' => $uniqueFunds->values(), // Collection of unique funds
                ];
            })
            ->filter(fn ($companyGroup, $key) => $key != '' && $companyGroup['count'] > 1)
            ->values()
            ->groupBy('count');

        return $result;
    }

    private function buildMutualFundQuery($filters, $onlyTicker = false)
    {
        if (empty($filters)) return null;

        $query = DB::connection('pgsql-xbrl')
            ->table('mutual_fund_holdings');

        if ($onlyTicker) {
            // Select only the ticker if $onlyTicker is true
            $query->select('symbol as ticker');
        } else {
            // Select all columns if $onlyTicker is false
            $query->select(
                'cik',
                'registrant_name as name',
                'fund_symbol',
                'name as company_name',
                'symbol as ticker',
                'change_in_balance as change_amount',
                'series_id',
                'class_id',
                'class_name',
                'previous_weight as previous',
                'price_per_unit as price',
            );
        }

        // Apply filters if any
        if ($filters) {
            $query->when($filters, function ($query) use ($filters) {
                foreach ($filters as $filter) {
                    $query->orWhere(function ($subQuery) use ($filter) {
                        $subQuery->where('cik', $filter['cik'])
                            ->where('fund_symbol', $filter['fund_symbol'])
                            ->where('series_id', $filter['series_id'])
                            ->where('class_id', $filter['class_id'])
                            ->where('period_of_report', $filter['period']);
                    });
                }
            });
        }

        return $query;
    }

    private function buildFundQuery($filters, $onlyTicker = false)
    {
        if (empty($filters)) return null;

        $query = DB::connection('pgsql-xbrl')
            ->table('filings');

        if ($onlyTicker) {
            // Select only the ticker if $onlyTicker is true
            $query->select('symbol as ticker');
        } else {
            // Select all columns if $onlyTicker is false
            $query->select(
                'cik',
                'investor_name as name',
                DB::raw('NULL AS fund_symbol'),
                'name_of_issuer as company_name',
                'symbol as ticker',
                'change_in_shares as change_amount',
                DB::raw('NULL AS series_id'),
                DB::raw('NULL AS class_id'),
                DB::raw('NULL AS class_name'),
                'last_shares as previous',
                'price_paid as price',
            );
        }

        // Apply filters if any
        if ($filters) {
            $query->when($filters, function ($query) use ($filters) {
                foreach ($filters as $filter) {
                    $query->orWhere(function ($subQuery) use ($filter) {
                        $subQuery->where('cik', $filter['cik'])
                            ->where('report_calendar_or_quarter', $filter['period']);
                    });
                }
            });
        }

        return $query;
    }

    private function getOverlapMatrix($investors, $itemsPerPage = 5)
    {
        Cache::forget($this->cacheKey);

        Cache::remember($this->cacheKey, Carbon::now()->addMinutes(30), function() use($investors, $itemsPerPage) {
            $groupedByCount = $this->getOverlapMatrixData($investors);

            $paginatedGroups = $groupedByCount->map(function ($group) use ($itemsPerPage) {
                return $group->chunk($itemsPerPage);
            });

            // Load the initial pages
            $this->overlapMatrix = $paginatedGroups->map(function ($pages, $key) use($groupedByCount) {
                $item = $pages->first();
                return [
                    'items' => $item,
                    'investorCount' => $key,
                    'countMore' => $groupedByCount[$key]->count() - $item->count(),
                ];
            });

            // Initialize loaded counts and page numbers
            $this->loadedCounts = $groupedByCount->map(fn($group) => 1);
            $this->itemsPerPage = $itemsPerPage;

            return $paginatedGroups;
        });
    }

    public function loadMoreOverlapMatrix($investorCount, $additional = 1)
    {
        if (! Cache::has($this->cacheKey)) {
            $groupedByCount = $this->getOverlapMatrixData($this->investors);

            $paginatedGroups = $groupedByCount->map(function ($group) {
                return $group->chunk($this->itemsPerPage);
            });

            Cache::put($this->cacheKey, $paginatedGroups, Carbon::now()->addMinutes(30));
        } else {
            $paginatedGroups = Cache::get($this->cacheKey);
        }

        if (!isset($this->loadedCounts[$investorCount])) {
            return;
        }

        $loadedCount = $this->loadedCounts[$investorCount];
        $newLoadedCount = $loadedCount + $additional;

        $group = $paginatedGroups[$investorCount] ?? collect();

        // Ensure we don't exceed the available pages
        $newPages = $group->take($newLoadedCount);

        $this->loadedCounts[$investorCount] = $newLoadedCount;
        $this->overlapMatrix = $this->overlapMatrix->map(function ($item, $key) use ($investorCount, $newPages, $additional) {
            if ($key == $investorCount) {
                return [
                    'items' => $newPages->flatten(1),
                    'investorCount' => $key,
                    'countMore' => $item['countMore'] - $this->itemsPerPage * $additional,
                ];
            }
            return $item;
        });
    }

    private function getFavouriteMutualFunds($mutualFundsQuery, $favouriteMutualFunds)
    {
        if (empty($favouriteMutualFunds)) {
            return collect([]);
        }

        return $mutualFundsQuery->where(function ($query) use ($favouriteMutualFunds) {
            foreach ($favouriteMutualFunds as $identifier) {
                $fund = json_decode($identifier, true);
                $query->orWhere(function ($q) use ($fund) {
                    $q->where('cik', $fund['cik'])
                    ->where('series_id', $fund['series_id'])
                    ->where('class_id', $fund['class_id']);
                });
            }
        })->get();
    }

    private function processFundsData($funds, $favouriteFunds)
    {
        $funds->transform(function ($fund) use ($favouriteFunds) {
            $fundArray = (array) $fund;
            $fundArray['type'] = 'fund';
            $fundArray['series_id'] = '';
            $fundArray['class_id'] = '';
            $fundArray['class_name'] = '';
            $fundArray['isFavorite'] = in_array($fundArray['cik'], $favouriteFunds);

            return $fundArray;
        });
    }

    private function processMutualFundsData($mutualFunds, $favouriteMutualFunds)
    {
        $mutualFunds->transform(function ($mutualFund) use ($favouriteMutualFunds) {
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

            $fundArray['isFavorite'] = in_array($id, $favouriteMutualFunds);
            $key = $fundArray['cik'] . '-' . $fundArray['fund_symbol'] . '-' . $fundArray['series_id'] . '-' . $fundArray['class_id'];

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
