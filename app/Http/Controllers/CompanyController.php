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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

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

        $cacheKey = 'company_data_' . $ticker;

        $cacheDuration = 3600;

        $company = Cache::remember($cacheKey, $cacheDuration, function () use ($ticker) {
            return Company::query()
                ->where('ticker', $ticker)
                // ->where('ticker', OwnershipHistoryService::getCompany())
                ->firstOrFail();
        });

        $cacheKey = 'current_company_data_' . $ticker;

        $currentCompany = $ticker === $company->ticker ? $company :
            Cache::remember($cacheKey, $cacheDuration, function () use ($ticker) {
                return Company::query()
                    ->where('ticker', $ticker)
                    ->firstOrFail();
            });

        return view('layouts.company', [
            'company' => $company,
            'ticker' => $company->ticker,
            'currentCompany' => $currentCompany,
            'tab' => 'ownership'
        ]);
    }

    public function fund(string $fund, ?string $company = null)
    {

        $cacheKey = 'fund_by_cik_' . $fund;

        $cacheDuration = 3600;

        $fund = Cache::remember($cacheKey, $cacheDuration, function () use ($fund) {
            return Fund::where('cik', $fund)->firstOrFail();
        });

        $currentCompany = null;

        if ($company) {
            $cacheKey = 'company_by_ticker_' . $company;
            $cacheDuration = 3600;

            $currentCompany = Cache::remember($cacheKey, $cacheDuration, function () use ($company) {
                return Company::query()
                    ->where('ticker', $company)
                    ->first();
            });
        }

        $companyTicker = OwnershipHistoryService::getCompany();

        $cacheKey = 'initial_company_' . $companyTicker;

        $initialCompany = Cache::remember($cacheKey, $cacheDuration, function () use ($companyTicker) {
            return Company::query()
                ->where('ticker', $companyTicker)
                ->firstOrFail();
        });

        return view('layouts.company', [
            'company' => $initialCompany,
            'currentCompany' => $currentCompany,
            'tab' => 'fund',
            'fund' => $fund,
        ]);
    }

    public function mutualFund(Request $request, ?string $company = null)
    {
        $fund = MutualFunds::query()->where('fund_symbol', $request->route('fund_symbol'))->firstOrFail();

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

    public function icon(Request $request)
    {
        $domain = $request->input('domain');
        $key = config('services.logo.key');

        if ($domain) {
            $cacheKey = "icon_{$domain}";
            $cacheDuration = 60 * 24; // Cache for 24 hours

            // Try to get the cached icon
            if (Cache::has($cacheKey)) {
                $cachedFilePath = Cache::get($cacheKey);
                if (Storage::exists($cachedFilePath)) {
                    return response()->file(storage_path('app/' . $cachedFilePath));
                }
            }

            $sourceLink = "https://img.logo.dev/{$domain}?token={$key}";

            $response = Http::get($sourceLink);

            if ($response->ok()) {
                // Store the icon in a file
                $fileName = md5($domain) . '.png'; // Unique file name based on the domain
                $filePath = 'icons/' . $fileName;
                Storage::put($filePath, $response->body());

                // Cache the file path
                Cache::put($cacheKey, $filePath, $cacheDuration);

                return response()->file(storage_path('app/' . $filePath));
            }
        }

        $localIconPath = public_path('img/logo1.png');

        if (file_exists($localIconPath)) {
            return response()->file($localIconPath, [
                'Content-Type' => 'image/png',
                'Content-Disposition' => 'inline; filename="icon.png"',
            ]);
        } else {
            abort(404, 'Icon not found');
        }
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
