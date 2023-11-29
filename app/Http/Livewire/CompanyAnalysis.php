<?php

namespace App\Http\Livewire;

use App\Models\EodPrices;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyAnalysis extends Component
{
    use TableFiltersTrait;

    public $noData = false;
    public $cost;
    public $company;
    public $ticker;
    public $companyName;

    public function mount(Request $request, $company, $ticker, $period)
    {
        // $first = DB::connection('pgsql-xbrl')
        //     ->table('eod_prices')
        //     ->where('symbol', strtolower($this->ticker))
        //     ->latest('date')->first()?->adj_close;
        // $previous = DB::connection('pgsql-xbrl')
        //     ->table('eod_prices')
        //     ->where('symbol', strtolower($this->ticker))
        //     ->latest('date')
        //     ->skip(1)->first()?->adj_close;
        // if ($previous && $first) {
        //     $this->dynamic = round((($first - $previous) / $previous) * 100, 2);
        // }

        $eodPrices = EodPrices::where('symbol', strtolower($this->company->ticker))
            ->latest('date')
            ->take(2)
            ->pluck('adj_close')
            ->toArray();

        $latestPrice = $eodPrices[0] ?? 0;
        $previousPrice = $eodPrices[1] ?? 0;

        if ($latestPrice > 0 && $previousPrice > 0) {
            $this->dynamic = round((($latestPrice - $previousPrice) / $previousPrice) * 100, 2);
        }

        $this->cost =  $latestPrice;
        $this->company = $company;
        $this->ticker = $ticker;
        $this->period = $period;
        $this->companyName = $this->ticker;

    }

    public function render()
    {
        return view('livewire.company-analysis');
    }
}
