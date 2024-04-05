<?php

namespace App\Http\Livewire\Ownership;

use Livewire\Component;
use App\Http\Livewire\AsTab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyInsiders extends Component
{
    use AsTab;

    protected array $filters = [];
    public string $ticker;

    public static function title(): string
    {
        return 'AAPL Insider Transactions';
    }

    public function mount(array $data = [], Request $request)
    {
        $this->ticker = $data['company']['ticker'];

        if ($request->query('search')) {
            $this->filters['search'] = $request->query('search');
        }

        if ($request->query('transaction_codes')) {
            $this->filters['transaction_codes'] = array_values(array_filter(
                explode(',', $request->query('transaction_codes')),
                fn ($code) => in_array($code, array_keys(config('capitalyze.transaction_code_map')))
            ));
        }

        if ($request->query('relationships')) {
            $this->filters['relationships'] = array_values(array_filter(
                explode(',', $request->query('relationships')),
                fn ($relationship) => in_array($relationship, $this->relationships)
            ));
        }

        if ($request->query('transaction_value')) {
            [$min, $max] = explode('-', $request->query('transaction_value'));
            $min = intval($min) ?? 0;
            $max = intval($max) ?? 0;

            if ($min || $max) {
                $this->filters['transaction_value'] = [
                    'min' => $min,
                    'max' => $max,
                ];
            }
        }

        if ($request->query('months')) {
            $this->filters['months'] = intval($request->query('months'));
        }

        if ($request->query('cso')) {
            $this->filters['cso'] = intval($request->query('cso'));
        }
    }

    public function render()
    {
        return view('livewire.ownership.company-insiders', [
            'insiderTitles' => $this->getTopInsiderTitles(),
            'filters' => $this->filters,
        ]);
    }

    private function getTopInsiderTitles()
    {
        return DB::connection('pgsql-xbrl')
            ->table('insider_transactions')
            ->where('symbol', '=', $this->ticker)
            ->select(['relationship_of_reporting_person', DB::raw('count(*) as count')])
            ->groupBy('relationship_of_reporting_person')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->pluck('relationship_of_reporting_person', 'relationship_of_reporting_person')
            ->toArray();
    }
}
