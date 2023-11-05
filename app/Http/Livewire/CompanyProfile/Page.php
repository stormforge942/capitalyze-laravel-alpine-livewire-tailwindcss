<?php

namespace App\Http\Livewire\CompanyProfile;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Page extends Component
{
    public $company;

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
                    ->toArray()
            ],
            ...$this->getCostAndDynamic(),
        ]);
    }

    private function getCostAndDynamic()
    {
        $eodPrices = DB::connection('pgsql-xbrl')
            ->table('eod_prices')
            ->where('symbol', strtolower($this->company->ticker))
            ->latest('date')
            ->pluck('adj_close')
            ->toArray();

        $first = $eodPrices[0] ?? 0;
        $previous = $eodPrices[1] ?? 0;

        $dynamic = 0;

        if ($first && $previous) {
            $dynamic = round((($first - $previous) / $previous) * 100, 2);
        }

        return [
            'cost' => $first,
            'dynamic' => $dynamic,
        ];
    }
}
