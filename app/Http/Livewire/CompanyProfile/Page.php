<?php

namespace App\Http\Livewire\CompanyProfile;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Page extends Component
{
    public $company;
    public $period;

    public function render()
    {
        return view('livewire.company-profile.page', [
            'tabs' => [
                CompanyOverview::class,
                BusinessInformation::class,
            ],
            'tabData' => [
                'profile' => \App\Models\CompanyProfile::query()
                    ->where('symbol', $this->company->ticker)
                    ->firstOrFail()
                    ->toArray(),
                'period' => $this->period,
            ],
            ...$this->getCostAndDynamic(),
        ]);
    }

    private function getCostAndDynamic()
    {
        // Retrieve the latest two adjusted closing prices for the given company's ticker symbol
        $eodPrices = DB::connection('pgsql-xbrl')
            ->table('eod_prices')
            ->where('symbol', strtolower($this->company->ticker)) // Ensure the ticker symbol is in lowercase
            ->latest('date') // Order by date, descending
            ->take(2) // Limit the results to the latest two records
            ->pluck('adj_close') // Retrieve only the 'adj_close' column
            ->toArray(); // Convert the collection to an array

        // Initialize variables to store the most recent and previous prices
        $latestPrice = $eodPrices[0] ?? 0; // Use null coalescing operator to avoid undefined index errors
        $previousPrice = $eodPrices[1] ?? 0;

        // Initialize the percentage change variable
        $percentageChange = 0;

        // Calculate the percentage change if both latest and previous prices are available and not zero
        if ($latestPrice > 0 && $previousPrice > 0) {
            $percentageChange = round((($latestPrice - $previousPrice) / $previousPrice) * 100, 2);
        }

            // Return an associative array with the latest price and the percentage change
        return [
            'cost' => $latestPrice,
            'dynamic' => $percentageChange,
        ];
    }
}
