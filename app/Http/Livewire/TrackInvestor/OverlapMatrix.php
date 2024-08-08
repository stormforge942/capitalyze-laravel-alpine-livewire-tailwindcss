<?php

namespace App\Http\Livewire\TrackInvestor;

use App\Http\Livewire\AsTab;
use App\Models\CompanyFilings;
use App\Models\MutualFundsPage;
use App\Models\TrackInvestorFavorite;
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

    public function getInvestors()
    {
        $this->canLoadMore = true;
        $offset = ($this->page - 1) * $this->limit;

        $fundsQuery = DB::connection('pgsql-xbrl')
            ->table('filings_summary')
            ->select(
                'filings_summary.investor_name as name',
                'filings_summary.cik as cik',
                'filings_summary.total_value as total_value',
                'filings_summary.portfolio_size as portfolio_size',
                'filings_summary.change_in_total_value as change_in_total_value',
                'filings_summary.date as date',
                DB::raw('COUNT(DISTINCT filings.name_of_issuer) as stock_count')
            )
            ->leftJoin('filings', 'filings_summary.cik', '=', 'filings.cik')
            ->when($this->search, function ($query, $search) {
                return $query->where('filings_summary.investor_name', 'ilike', '%' . $search . '%');
            })
            ->groupBy(
                'filings_summary.investor_name',
                'filings_summary.cik',
                'filings_summary.total_value',
                'filings_summary.portfolio_size',
                'filings_summary.change_in_total_value',
                'filings_summary.date'
            );

        $mutualFundsQuery = DB::connection('pgsql-xbrl')
            ->table('mutual_fund_holdings_summary')
            ->select(
                'mutual_fund_holdings_summary.registrant_name as name',
                'mutual_fund_holdings_summary.cik as cik',
                'mutual_fund_holdings_summary.total_value as total_value',
                'mutual_fund_holdings_summary.portfolio_size as portfolio_size',
                'mutual_fund_holdings_summary.change_in_total_value as change_in_total_value',
                'mutual_fund_holdings_summary.fund_symbol as fund_symbol',
                'mutual_fund_holdings_summary.series_id as series_id',
                'mutual_fund_holdings_summary.class_id as class_id',
                'mutual_fund_holdings_summary.class_name as class_name',
                'mutual_fund_holdings_summary.date as date',
                DB::raw('COUNT(DISTINCT mutual_fund_holdings.name) as stock_count')
            )
            ->leftJoin('mutual_fund_holdings', function ($join) {
                $join->on('mutual_fund_holdings_summary.cik', '=', 'mutual_fund_holdings.cik')
                    ->on('mutual_fund_holdings_summary.fund_symbol', '=', 'mutual_fund_holdings.fund_symbol')
                    ->on('mutual_fund_holdings_summary.series_id', '=', 'mutual_fund_holdings.series_id')
                    ->on('mutual_fund_holdings_summary.class_id', '=', 'mutual_fund_holdings.class_id');
            })
            ->when($this->search, function ($query, $search) {
                return $query->where('mutual_fund_holdings_summary.registrant_name', 'ilike', '%' . $search . '%')
                    ->orWhere('mutual_fund_holdings_summary.fund_symbol', 'ilike', '%' . $search . '%');
            })
            ->groupBy(
                'mutual_fund_holdings_summary.registrant_name',
                'mutual_fund_holdings_summary.cik',
                'mutual_fund_holdings_summary.total_value',
                'mutual_fund_holdings_summary.portfolio_size',
                'mutual_fund_holdings_summary.change_in_total_value',
                'mutual_fund_holdings_summary.fund_symbol',
                'mutual_fund_holdings_summary.series_id',
                'mutual_fund_holdings_summary.class_id',
                'mutual_fund_holdings_summary.class_name',
                'mutual_fund_holdings_summary.date'
            );

        $favouriteFunds = TrackInvestorFavorite::where('user_id', Auth::id())
            ->where('type', TrackInvestorFavorite::TYPE_FUND)
            ->pluck('identifier')
            ->toArray();

        $favouriteIdentifiers = TrackInvestorFavorite::where('user_id', Auth::id())
            ->where('type', TrackInvestorFavorite::TYPE_MUTUAL_FUND)
            ->pluck('identifier');

        $favouriteMutualFunds = $favouriteIdentifiers->map(function ($identifier) {
            return json_decode($identifier, true);
        });

        $favouriteIdentifiers = $favouriteIdentifiers->toArray();

        if ($this->category === 'fund') {
            $funds = $fundsQuery->skip($offset)->take($this->limit)->get();
            if (count($funds) < $this->limit) {
                $this->canLoadMore = false;
            }
            $mutualFunds = collect([]);
        } elseif ($this->category === 'mutual_fund') {
            $mutualFunds = $mutualFundsQuery->skip($offset)->take($this->limit)->get();
            if (count($mutualFunds) < $this->limit) {
                $this->canLoadMore = false;
            }
            $funds = collect([]);
        } elseif ($this->category === 'favourite') {
            $funds = $fundsQuery->whereIn('filings_summary.cik', $favouriteFunds)->get();

            if (count($favouriteMutualFunds) == 0) {
                $mutualFunds = collect([]);
            } else {
                $mutualFunds = $mutualFundsQuery->where(function ($q) use ($favouriteMutualFunds) {
                    foreach ($favouriteMutualFunds as $fund) {
                        $q->orWhere(
                            fn($q) => $q->where('mutual_fund_holdings_summary.cik', $fund['cik'])
                                ->where('mutual_fund_holdings_summary.series_id', $fund['series_id'])
                                ->where('mutual_fund_holdings_summary.class_id', $fund['class_id'])
                                ->where('mutual_fund_holdings_summary.class_name', $fund['class_name'])
                        );
                    }
                    return $q;
                })->get();
            }
        } else {
            $funds = $fundsQuery->skip($offset)->take($this->limit)->get();
            $mutualFunds = $mutualFundsQuery->skip($offset)->take($this->limit)->get();

            if (count($funds) < $this->limit && count($mutualFunds) < $this->limit) {
                $this->canLoadMore = false;
            }
        }

        $funds = $funds->map(function ($fund) use ($favouriteFunds) {
            $fundArray = (array) $fund;
            $fundArray['type'] = 'fund';
            $fundArray['series_id'] = '';
            $fundArray['class_id'] = '';
            $fundArray['class_name'] = '';
            $fundArray['isFavorite'] = in_array($fundArray['cik'], $favouriteFunds);

            return $fundArray;
        });

        $mutualFunds = $mutualFunds->map(function ($mutualFund) use ($favouriteIdentifiers) {
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

            return $fundArray;
        });

        // Remove duplicate data and keep latest one
        $combinedData = $funds->merge($mutualFunds);
        $combinedData = $combinedData->sortByDesc('date');
        $combinedData = $combinedData->unique(function ($item) {
            return $item['type'] . $item['cik'] . $item['series_id'] . $item['class_id'] . $item['class_name'];
        });

        $this->investors = $this->investors->merge($combinedData);
        $this->loading = false;
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

    public function getOverlapMatrix($investors)
    {
        $period = '';

        // Define filter conditions
        $mutualFundFilterCIKs = [];
        $mutualFundFilterNames = [];
        $mutualFundFilterFundSymbols = [];
        $mutualFundFilterSeriesIDs = [];
        $mutualFundFilterClassIDs = [];
        $mutualFundFilterClassNames = [];
        $fundFilterCIKs = [];

        // Filter by investor type
        foreach ($investors as $investor) {
            if ($investor['type'] === 'fund') {
                $fundFilterCIKs[] = $investor['cik'];
            } else {
                $mutualFundFilterCIKs[] = $investor['cik'];
                $mutualFundFilterNames[] = $investor['name'];
                $mutualFundFilterFundSymbols[] = $investor['fund_symbol'];
                $mutualFundFilterSeriesIDs[] = $investor['series_id'];
                $mutualFundFilterClassIDs[] = $investor['class_id'];
                $mutualFundFilterClassNames[] = $investor['class_name'];
            }
        }

        // Fetch filtered mutual funds data
        $filteredMutualFunds = MutualFundsPage::select('cik', 'registrant_name as name', 'fund_symbol', 'name as company_name', 'symbol as ticker', 'change_in_balance as change_amount', 'series_id', 'class_id', 'class_name', 'previous_weight as previous', 'price_per_unit as price')
            ->whereIn('cik', $mutualFundFilterCIKs)
            ->whereIn('registrant_name', $mutualFundFilterNames)
            ->whereIn('fund_symbol', $mutualFundFilterFundSymbols)
            ->whereIn('series_id', $mutualFundFilterSeriesIDs)
            ->whereIn('class_id', $mutualFundFilterClassIDs)
            ->whereIn('class_name', $mutualFundFilterClassNames)
            ->get();

        // Fetch filtered funds data
        $filteredFunds = CompanyFilings::select('cik', 'investor_name as name', 'name_of_issuer as company_name', 'symbol as ticker', 'change_in_shares as change_amount', 'last_shares as previous', 'price_paid as price')
            ->whereIn('cik', $fundFilterCIKs)
            ->get();

        $filteredFunds = $filteredFunds->map(function ($fund) {
            $fund['series_id'] = '';
            $fund['class_id'] = '';
            $fund['class_name'] = '';
            return $fund;
        });

        // Convert collections to arrays
        $filteredMutualFundsArray = $filteredMutualFunds->toArray();
        $filteredFundsArray = $filteredFunds->toArray();

        // Combine the data as arrays and then convert back to a collection
        $combinedDataArray = array_merge($filteredMutualFundsArray, $filteredFundsArray);
        $combinedData = collect($combinedDataArray);

        // Group by company_name and count distinct cik values
        $result = $combinedData->groupBy('company_name')
            ->map(function ($companyGroup) {
                $uniqueFunds = $companyGroup->unique(function ($item) {
                    return $item['cik'] . $item['series_id'] . $item['class_id'] . $item['class_name'];
                });

                $company_name = $companyGroup->first()['company_name'];
                $ticker = $companyGroup->first()['ticker'];
                $price = DB::connection('pgsql-xbrl')
                    ->table('eod_prices')
                    ->select('close')
                    ->where('symbol', strtolower($ticker))
                    ->orderBy('date', 'desc')
                    ->first();

                $price = $price ? $price : (object) ['close' => 0];

                return [
                    'company_name' => $company_name,
                    'ticker' => $ticker,
                    'price' => $price->close,
                    'count' => $uniqueFunds->count(),
                    'funds' => $uniqueFunds->values(),
                ];
            });

        $this->overlapMatrix = $result->values()->sortByDesc('count')->groupBy('count');
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
