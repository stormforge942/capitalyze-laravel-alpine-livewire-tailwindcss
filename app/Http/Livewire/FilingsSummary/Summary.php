<?php

namespace App\Http\Livewire\FilingsSummary;

use App\Models\TrackInvestorDocumentsOpened;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use DB;
use Illuminate\Support\Facades\Cache;

class Summary extends Component
{
    public $data = [];
    public $company;
    public $col = "acceptance_time";
    public $order = "desc";
    public $values = [];
    public $items;

    protected $listeners = ['markAsRead'];

    public function mount(){
        $viewed = TrackInvestorDocumentsOpened::where('user_id', Auth::id())
            ->pluck('key')
            ->toArray();

        $data = $this->getDataFromDB()->map(function ($summary) use ($viewed) {
            $summary = (array) $summary;
            $key = $summary['acceptance_time'] . '_' . $summary['symbol'] . '_' . $summary['form_type'];
            $summary['isViewed'] = in_array($key, $viewed);

            return $summary;
        });

        $this->values = $data;
        $this->items = getFilingsSummaryTab();
    }

    public function getDataFromDB(){

        $cacheKey = 'company_links_' . $this->company->ticker . '_' . $this->col . '_' . $this->order;
        $cacheDuration = 3600;

        $query = Cache::remember($cacheKey, $cacheDuration, function () {
            return DB::connection('pgsql-xbrl')
                ->table('company_links')
                ->where('symbol', $this->company->ticker)
                ->whereRaw("SUBSTRING(acceptance_time, 1, 4)::integer > 2018")
                ->orderBy($this->col, $this->order)
                ->get();
        });
        
        return $query;
    }

    public function markAsRead($row)
    {
        $key = $row['acceptance_time'] . '_' . $row['symbol'] . '_' . $row['form_type'];

        $entry = TrackInvestorDocumentsOpened::query()
            ->where('key', $key)
            ->where('user_id', Auth::id())
            ->first();

        if (!$entry) {
            TrackInvestorDocumentsOpened::create([
                'key' => $key,
                'user_id' => Auth::id(),
            ]);
        }
    }

    public function render()
    {
        return view('livewire.filings-summary.summary');
    }

    public function handleViewAll($val){
        $this->emit('handleFilingsSummaryTab', ['all-filings', $val]);        
    }
}
