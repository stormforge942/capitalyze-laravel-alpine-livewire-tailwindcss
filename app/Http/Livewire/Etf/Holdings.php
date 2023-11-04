<?php

namespace App\Http\Livewire\Etf;

use App\Models\Etfs;
use Livewire\Component;

class Holdings extends Component
{
    public $etf;
    public string $quarter = '';
    public array $quarters = [];

    protected $queryString = [
        'quarter' => ['except' => ''],
    ];

    public function mount()
    {
        $this->quarters = $this->generateQuarters();

        if (!$this->quarter || !array_key_exists($this->quarter, $this->quarters)) {
            $this->quarter = array_key_first($this->quarters) ?? '';
        }
    }

    public function updatedQuarter()
    {
        $this->emitTo(
            HoldingsTable::class,
            'quarterChanged',
            $this->quarter
        );
    }

    public function render()
    {
        return view('livewire.etf.holdings');
    }

    private function generateQuarters()
    {
        $periodOfReport = Etfs::query()
            ->where('cik', $this->etf->cik)
            ->where('etf_symbol', $this->etf->etf_symbol)
            ->distinct()
            ->pluck('period_of_report')
            ->mapWithKeys(function ($period) {
                return [$period => $period];
            })
            ->toArray();

        return array_reverse($periodOfReport, true);
    }
}
