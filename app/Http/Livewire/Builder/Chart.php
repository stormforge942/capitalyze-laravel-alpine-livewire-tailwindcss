<?php

namespace App\Http\Livewire\Builder;

use App\Models\CompanyChartComparison;
use Livewire\Component;
use App\Models\InfoTikrPresentation;
use Illuminate\Support\Facades\Auth;

class Chart extends Component
{
    public array $tabs = [];
    public int $activeTab = 0;

    public function mount()
    {
        $tabs = CompanyChartComparison::query()
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'asc')
            ->get();

        if ($tabs->isEmpty()) {
            $tabs->push(CompanyChartComparison::query()->create([
                'name' => 'Untitled Chart',
                'companies' => [],
                'metrics' => [],
                'user_id' => Auth::id()
            ]));
        }

        $this->activeTab = $tabs->last()->id;
        $this->tabs = $tabs->toArray();
    }

    public function render()
    {

        return view('livewire.builder.chart');
    }

    public function deleteTab($id)
    {
        CompanyChartComparison::query()
            ->where('id', $id)
            ->delete();

        $this->mount();
    }

    public function clearAll()
    {
        CompanyChartComparison::query()
            ->where('user_id', Auth::id())
            ->delete();

        $this->mount();
    }

    public function updateTab($id, $name)
    {
        CompanyChartComparison::query()
            ->where('id', $id)
            ->update(['name' => $name]);

        $this->mount();
    }

    public function addTab()
    {
        CompanyChartComparison::query()->create([
            'name' => 'Untitled Chart',
            'companies' => [],
            'metrics' => [],
            'user_id' => Auth::id()
        ]);

        $this->mount();
    }

    public function getData()
    {
        $companies = ['AAPL', 'MSFT'];

        $metrics = [
            'income||revenue||tr',
            'income||income||toi',
            'income||expenses||toe',
            'balance||cae',
            'balance||tr',
            'balance||tca',
        ];

        $data = $this->getKeyData($companies, $metrics, 'annual');

        dd($data);

        foreach ($companies as $company) {
            $storage = [];


            $data[$company] = array_reduce(
                $selected,
                function ($carry, $item) use ($companies, &$storage) {
                    $this->getKeyData($companies, $item, $storage, 'annual');
                    $carry[] = $storage;
                    return $carry;
                },
                []
            );
        }
    }

    private function getKeyData(array $companies, array $metrics, string $period = 'annual')
    {
        $keys = array_map(fn ($metric) => explode('||', $metric), $metrics);

        $columns = [];

        foreach ($keys as $key) {
            if ($key[0] === 'income') {
                $columns[] = "income_statement";
            } else if ($key[0] === 'balance') {
                $columns[] = "balance_sheet";
            }
        }

        $data = InfoTikrPresentation::query()
            ->whereIn('ticker', $companies)
            ->where("period", $period)
            ->select($columns)
            ->get()
            ->map(function ($item) use ($keys, $columns) {
                foreach (['income_statement', 'balance_sheet'] as $key) {
                    if ($item->$key) {
                        $json = json_decode($item->$key, true);

                        $new = [];

                        foreach ($json as $_key => $value) {
                            $_key = explode('|', $_key)[0];
                            $new[$_key] = $value;
                        }

                        $item->$key = $new;
                    }

                    return $item;
                }

                return $item;
            })
            ->keyBy('ticker')
            ->toArray();

        return $data;
    }
}
