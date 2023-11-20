<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Services\OwnershipHistoryService;
use Illuminate\Routing\Controller as BaseController;

class CompanyController extends BaseController
{
    public function geographic(Request $request, $ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'geographical'
        ]);
    }

    public function executiveCompensation(Request $request, $ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'executiveCompensation'
        ]);
    }

    public function failToDeliver(Request $request, $ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'failToDeliver'
        ]);
    }

    public function product(Request $request, $ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'products'
        ]);
    }

    public function profile(Request $request, $ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'profile'
        ]);
    }

    public function splits(Request $request, $ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'splits'
        ]);
    }

    public function metrics(Request $request, $ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'metrics'
        ]);
    }

    public function chart(Request $request, $ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'chart'
        ]);
    }

    public function report(Request $request, $ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'report'
        ]);
    }

    public function trackInvestor(Request $request, $ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'track-investor'
        ]);
    }

    public function shareholders(Request $request, $ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'shareholders'
        ]);
    }

    public function summary(Request $request, $ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'summary'
        ]);
    }

    public function filings(Request $request, $ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'filings'
        ]);
    }

    public function insider(Request $request, $ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'insider'
        ]);
    }

    public function restatement(Request $request, $ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'restatement'
        ]);
    }

    public function employee(Request $request, $ticker)
    {
        $company = Company::where('ticker', $ticker)->get()->first();

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'employee'
        ]);
    }

    public function filingsSummary(Request $request, $ticker){
        $company = Company::where('ticker', $ticker)->get()->first();
        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'filings-summary'
        ]);
    }

    public function ownership(Request $request, string $ticker)
    {
        $historyCompany = OwnershipHistoryService::getCompany();

        if ($historyCompany !== $ticker) {
            OwnershipHistoryService::clear();
        }

        OwnershipHistoryService::setCompany($ticker);

        $of = $of ?? $ticker;

        $company = Company::query()
            ->where('ticker', $ticker)
            ->firstOrFail();

        $currentCompany = $ticker === $of ? $company :
            Company::query()
            ->where('ticker', $of)
            ->firstOrFail();

        return view('layouts.company', [
            'company' => $company,
            'currentCompany' => $currentCompany,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
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
            ->first();

        abort_if(!$intialCompany && !$currentCompany, 404);

        if (!$intialCompany && $currentCompany) {
            OwnershipHistoryService::setCompany($currentCompany->ticker);
            $intialCompany = $currentCompany->clone();
        }

        return view('layouts.company', [
            'company' => $intialCompany,
            'currentCompany' => $currentCompany,
            'tab' => 'fund',
            'fund' => $fund,
        ]);
    }

    public function analysis(Request $request, string $ticker){
        $company = Company::query()
            ->where('ticker', $ticker)
            ->firstOrFail();

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $ticker,
            'period' => $request->query('period', 'annual'),
            'tab' => 'analysis',
        ]);
    }
}
