<?php

namespace App\Http\Livewire\CompanyProfile;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Models\ExecutiveCompensation;

class ExecutiveCompensationTable extends Component
{
    public $symbol;
    public $data;
    public $year;
    public $years;
    public $search;

    protected $listeners = ['updateExecutiveCompensationTable' => 'updateProps'];

    public function mount($symbol, $year)
    {
        $this->symbol = $symbol;
        $this->year = $year;
        $this->data = $this->getCompensations();
    }

    public function updateProps($search, $year)
    {
        $this->search = $search;
        $this->year = $year;
        $this->data = $this->getCompensations();
    }

    public function getCompensations()
    {
        $data = Cache::remember('executive_compensation_' . $this->search . '_' . $this->year . '_' . $this->symbol, now()->addMinutes(5), function () {
            return ExecutiveCompensation::query()
                ->when($this->symbol, fn ($q) => $q->where('symbol', $this->symbol))
                ->when($this->year, fn ($q) => $q->where('year', $this->year))
                ->when($this->search, function ($query) {
                    $term = '%' . $this->search . '%';

                    return $query->where('name_and_position', 'ilike', $term);
                })
                ->orderByDesc('filing_date')
                ->get();
        });

        $groupedData = $data->groupBy('filing_date')->map(function ($item) {
            return [
                's3_url' => $item->first()->s3_url,
                'url' => $item->first()->url,
                'data' => $item
            ];
        });

        return $groupedData;
    }

    public function render()
    {
        return view('livewire.company-profile.executive-compensation-table');
    }
}
