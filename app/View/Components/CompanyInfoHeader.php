<?php

namespace App\View\Components;

use App\Models\EodPrices;
use Illuminate\View\Component;

class CompanyInfoHeader extends Component
{
    public $percentageChange;
    public $latestPrice;

    public function __construct(
        public array $company
    ) {
        $eodPrices = EodPrices::where('symbol', strtolower($company['ticker']))
            ->latest('date')
            ->take(2)
            ->pluck('adj_close')
            ->toArray();

        [$latestPrice, $previousPrice] = [$eodPrices[0] ?? 0, $eodPrices[1] ?? 0];

        $this->percentageChange = ($latestPrice > 0 && $previousPrice > 0) ?
            round((($latestPrice - $previousPrice) / $previousPrice) * 100, 2)
            : 0;

        $this->latestPrice = $latestPrice;
    }

    public function render()
    {
        return view('components.company-info-header');
    }
}
