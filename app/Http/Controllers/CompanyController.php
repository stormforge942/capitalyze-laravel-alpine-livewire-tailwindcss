<?php

namespace App\Http\Controllers;

use App\Exceptions\CompanyNotFoundException;
use App\Models\Fund;
use App\Models\Company;
use App\Models\MutualFunds;
use Illuminate\Http\Request;
use App\Services\OwnershipHistoryService;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cache;

class CompanyController extends BaseController
{
    public function geographic(Request $request, $ticker)
    {
        $company = $this->findOrFailCompany($ticker);

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'geographical'
        ]);
    }

    public function executiveCompensation(Request $request, $ticker)
    {
        $company = $this->findOrFailCompany($ticker);

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'executiveCompensation'
        ]);
    }

    public function failToDeliver(Request $request, $ticker)
    {
        $company = $this->findOrFailCompany($ticker);

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'failToDeliver'
        ]);
    }

    public function product(Request $request, $ticker)
    {
        $company = $this->findOrFailCompany($ticker);

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'products'
        ]);
    }

    public function profile(Request $request, $ticker)
    {
        $company = $this->findOrFailCompany($ticker);

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'profile'
        ]);
    }

    public function splits(Request $request, $ticker)
    {
        $company = $this->findOrFailCompany($ticker);

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'splits'
        ]);
    }

    public function metrics(Request $request, $ticker)
    {
        $company = $this->findOrFailCompany($ticker);

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'metrics'
        ]);
    }

    public function chart(Request $request, $ticker)
    {
        $company = $this->findOrFailCompany($ticker);

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'chart'
        ]);
    }

    public function report(Request $request, $ticker)
    {
        $company = $this->findOrFailCompany($ticker);

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'report'
        ]);
    }

    public function shareholders(Request $request, $ticker)
    {
        $company = $this->findOrFailCompany($ticker);

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'shareholders'
        ]);
    }

    public function summary(Request $request, $ticker)
    {
        $company = $this->findOrFailCompany($ticker);

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'summary'
        ]);
    }

    public function filings(Request $request, $ticker)
    {
        $company = $this->findOrFailCompany($ticker);

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'filings'
        ]);
    }

    public function insider(Request $request, $ticker)
    {
        $company = $this->findOrFailCompany($ticker);

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'insider'
        ]);
    }

    public function restatement(Request $request, $ticker)
    {
        $company = $this->findOrFailCompany($ticker);

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'restatement'
        ]);
    }

    public function employee(Request $request, $ticker)
    {
        $company = $this->findOrFailCompany($ticker);

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'employee'
        ]);
    }

    public function filingsSummary(Request $request, $ticker)
    {
        $company = $this->findOrFailCompany($ticker);
        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'filings-summary'
        ]);
    }

    public function ownership(Request $request, string $ticker)
    {
        OwnershipHistoryService::setCompany($request->route('start', $ticker));

        $company = Company::query()
            ->where('ticker', $ticker)
            // ->where('ticker', OwnershipHistoryService::getCompany())
            ->firstOrFail();

        $currentCompany = $ticker === $company->ticker ? $company :
            Company::query()
            ->where('ticker', $ticker)
            ->firstOrFail();

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $company->ticker,
            'currentCompany' => $currentCompany,
            'tab' => 'ownership'
        ]);
    }

    public function fund(string $fund, ?string $company = null)
    {
        $fund = Fund::where('cik', $fund)->firstOrFail();

        $currentCompany = $company
            ? Company::query()
            ->where('ticker', $company)
            ->first()
            : null;

        $intialCompany = Company::query()
            ->where('ticker', OwnershipHistoryService::getCompany())
            ->firstOrFail();

        return view('layouts.company', [
            'company' => $intialCompany,
            'currentCompany' => $currentCompany,
            'tab' => 'fund',
            'fund' => $fund,
        ]);
    }

    public function mutualFund(Request $request, ?string $company = null)
    {
        $fund = MutualFunds::query()
            ->where('cik', $request->route('cik'))
            ->where('fund_symbol', $request->route('fund_symbol'))
            ->where('series_id', $request->route('series_id'))
            ->where('class_id', $request->route('class_id'))
            ->firstOrFail();

        $currentCompany = $company
            ? Company::query()
            ->where('ticker', $company)
            ->first()
            : null;

        $intialCompany = Company::query()
            ->where('ticker', OwnershipHistoryService::getCompany())
            ->firstOrFail();

        return view('layouts.company', [
            'company' => $intialCompany,
            'currentCompany' => $currentCompany,
            'tab' => 'mutual-fund',
            'fund' => $fund,
        ]);
    }

    public function analysis(Request $request, string $ticker)
    {
        $company = $this->findOrFailCompany($ticker);

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'analysis',
        ]);
    }

    private function findOrFailCompany(string $ticker)
    {
        $cacheKey = 'company_' . $ticker;

        $cacheDuration = 3600; 

        $company = Cache::remember($cacheKey, $cacheDuration, function () use ($ticker) {
            return Company::query()
                ->where('ticker', $ticker)
                ->first();
        });

        if (!$company) {
            throw new CompanyNotFoundException($ticker);
        }

        return $company;
    }
}
