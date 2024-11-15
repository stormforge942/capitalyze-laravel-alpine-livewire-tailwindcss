<?php

namespace App\Http\Livewire\InvestorAdviser;

use Livewire\Component;
use App\Services\OwnershipHistoryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Http\Livewire\AsTab;

class AdviserSummary extends Component
{
    use AsTab;

    public $company;
    public $adviser;

    public static function title(): string
    {
        return 'Summary';
    }

    public function mount($data)
    {
        $this->adviser = $data['adviser'];
        $this->company = $data['company'];
    }

    public function render()
    {
        return view('livewire.investor-adviser.adviser-summary');
    }
}
