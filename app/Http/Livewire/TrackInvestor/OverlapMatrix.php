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

        $data = Cache::remember('investors_' . $this->category . '_' . $this->search . '_' . $this->page . '_' . Auth::id(), $this->category !== 'favourite' ? 300 : 3, function () use ($offset) {
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
                ->where('is_latest', true)
                ->when($this->search, function ($query, $search) {
                    return $query->where('investor_name', 'ilike', '%' . $search . '%');
                })
                ->orderBy('portfolio_size', 'desc');
                

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
                    $mutualFunds = $this->getFavouriteMutualFunds($mutualFundsQuery, $favouriteIdentifiers);
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
            $this->processMutualFundsData($mutualFunds, $favouriteIdentifiers); 

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
                $fundFilters[] = [
                    'cik' => $investor['cik'],
                    'period' => $investor['date'],
                ];
            } else {
                $mutualFundFilters[] = [
                    'cik' => $investor['cik'],
                    'registrant_name' => $investor['name'],
                    'fund_symbol' => $investor['fund_symbol'],
                    'series_id' => $investor['series_id'],
                    'class_id' => $investor['class_id'],
                    'class_name' => $investor['class_name'],
                    'period' => $investor['date'],
                ];
            }
        }

        // Fetch filtered mutual funds data
        $filteredMutualFunds = collect();
        if (count($mutualFundFilters)) {
            $filteredMutualFunds = DB::connection('pgsql-xbrl')
                ->table('mutual_fund_holdings')
                ->select(
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
                    'balance as ssh_prnamt'
                )
                ->where(function($query) use ($mutualFundFilters) {
                    foreach ($mutualFundFilters as $filter) {
                        $query->orWhere(function($subQuery) use ($filter) {
                            $startDate = Carbon::parse($filter['period'])->startOfQuarter()->format('Y-m-d');
                            $endDate = Carbon::parse($filter['period'])->endOfQuarter()->format('Y-m-d');

                            $subQuery->where('cik', $filter['cik'])
                                ->where('registrant_name', $filter['registrant_name'])
                                ->where('fund_symbol', $filter['fund_symbol'])
                                ->where('series_id', $filter['series_id'])
                                ->where('class_id', $filter['class_id'])
                                ->where('class_name', $filter['class_name'])
                                ->whereBetween('period_of_report', [$startDate, $endDate]);
                        });
                    }
                })
                ->get();
        }

        $filteredFunds = collect();
        if (count($fundFilters)) {
            $filteredFunds = DB::connection('pgsql-xbrl')
                ->table('filings')
                ->select(
                    'cik',
                    'investor_name as name',
                    'name_of_issuer as company_name',
                    'symbol as ticker',
                    'change_in_shares as change_amount',
                    'last_shares as previous',
                    'price_paid as price',
                    'ssh_prnamt',
                    DB::raw('NULL AS fund_symbol'),
                    DB::raw('NULL AS series_id'),
                    DB::raw('NULL AS class_id'),
                    DB::raw('NULL AS class_name')
                )
                ->where(function ($query) use ($fundFilters) {
                    foreach ($fundFilters as $filter) {
                        $query->orWhere(function ($subQuery) use ($filter) {
                            $subQuery->where('cik', $filter['cik'])
                                ->where('report_calendar_or_quarter', $filter['period']);
                        });
                    }
                })
                ->get();
        }

        // Convert collections to arrays
        $combinedData = $filteredMutualFunds->concat($filteredFunds)->sortByDesc('change_amount');

        $result = $combinedData->groupBy('ticker')
            ->map(function ($companyGroup) {
                $uniqueFunds = $companyGroup->unique(function ($item) {
                    return $item->cik . $item->series_id . $item->class_id . $item->class_name;
                });

                // Avoid calling first() multiple times
                $firstItem = $companyGroup->first();
                $ticker = $firstItem->ticker;
                $companyName = $firstItem->company_name;
                $price = number_format($firstItem->price, 2);
                $ssh_prnamt = $firstItem->ssh_prnamt;

                return [
                    'ticker' => $ticker,
                    'price' => $price,
                    'ssh_prnamt' => $ssh_prnamt,
                    'company_name' => $companyName,
                    'count' => $uniqueFunds->count(),
                    'funds' => $uniqueFunds->values(),
                ];
            });

        $this->overlapMatrix = $result->values()->groupBy('count');
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

    private function processMutualFundsData($mutualFunds, $favouriteIdentifiers)
    {
        $mutualFunds->transform(function ($mutualFund) use ($favouriteIdentifiers) {
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
