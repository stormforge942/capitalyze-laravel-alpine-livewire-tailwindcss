<?php

namespace App\Http\Livewire\Builder;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\InfoTikrPresentation;
use Illuminate\Support\Facades\Auth;
use App\Models\CompanyChartComparison;

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
        return view('livewire.builder.chart', [
            'data' => $this->getData(),
        ]);
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
            'income_statement||Total Revenue',
            'income_statement||Total Operating Income',
            'income_statement||Total Operating Expenses',
            'balance_sheet||Cash & Equivalents',
            'balance_sheet||Total Receivable',
            'balance_sheet||Total Current Assets',
        ];

        $data = array_reduce($companies, function ($c, $i) {
            $c[$i] = [];
            return $c;
        }, []);

        $this->fillStandarisedData($data, $metrics, 'annual');

        return $data;
    }

    private function fillStandarisedData(array &$data, array $metrics, string $period)
    {
        $standardKeys = [];
        foreach ($metrics as $metric) {
            if (!Str::startsWith($metric, ['income_statement||', 'balance_sheet||'])) {
                continue;
            }

            [$column, $key] = explode('||', $metric, 2);

            if (!isset($standardKeys[$column])) {
                $standardKeys[$column] = [];
            }

            $standardKeys[$column][] = $key;
        }

        if (empty($standardKeys)) {
            return $data;
        }

        $standardData = InfoTikrPresentation::query()
            ->whereIn('ticker', array_keys($data))
            ->where("period", $period)
            ->select(['ticker', ...array_keys($standardKeys)])
            ->get();

        foreach ($standardData as $item) {
            foreach ($standardKeys as $column => $keys) {
                $json = json_decode($item->{$column}, true);

                foreach ($json as $key => $_value) {
                    $key = explode('|', $key)[0];

                    if (!in_array($key, $keys)) {
                        continue;
                    }

                    $value = [];

                    foreach ($_value as $date => $v) {
                        $val = explode('|', $v[0])[0];
                        $value[$date] = $val ? round((float) $val, 3) : null;
                    }

                    $data[$item->ticker][$column . '||' . $key] = $value;
                }
            }
        }

        return $data;
    }
}
