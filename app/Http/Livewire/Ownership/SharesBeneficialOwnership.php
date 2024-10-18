<?php

namespace App\Http\Livewire\Ownership;

use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Http\Request;
use App\Http\Livewire\AsTab;
use Illuminate\Support\Facades\Cache;
use App\Models\SharesBeneficiallyOwned;

class SharesBeneficialOwnership extends Component
{
    use AsTab;

    public $ticker;
    public $years = [];
    public $year;

    public static function title(): string
    {
        return 'Shares Beneficial Ownership';
    }

    public function mount(array $data = [], Request $request)
    {
        $this->ticker = $data['company']['ticker'];
        $this->years = $this->getYears();
        $this->year = $this->years[0][0] ?? (now()->year);
    }

    private function getYears()
    {
        $years = SharesBeneficiallyOwned::query()
            ->select('acceptance_time')
            ->where('symbol', $this->ticker)
            ->orderByDesc('acceptance_time')
            ->get()
            ->pluck('acceptance_time')
            ->map(fn ($date) => Carbon::parse($date)->year)
            ->unique()
            ->toArray();
        
        $formattedYears = array_map(fn($year) => [$year, $year], $years);

        return $formattedYears;
    }

    public function getOwnership($year)
    {
        $data = Cache::remember('shares_beneficial_ownership_' . $year . '_' . $this->ticker, now()->addMinutes(5), function () use ($year) {
            return SharesBeneficiallyOwned::query()
                ->select('owner_name', 'shares_owned', 'url', 's3_url')
                ->when($this->ticker, fn ($q) => $q->where('symbol', $this->ticker))
                ->when($year, fn ($q) => $q->whereRaw('EXTRACT(YEAR FROM CAST(acceptance_time AS DATE)) = ?', [$year]))
                ->orderByDesc('shares_owned')
                ->get()
                ->toArray();
        });

        return $data;
    }

    public function render()
    {
        return view('livewire.ownership.shares-beneficial-ownership');
    }
}
