<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

abstract class BaseMetricsComponent extends Component
{
    public $title;
    public $model;
    public $metrics;
    public $segments;
    public $navbar;
    public $tables;
    public $period;
    public $activeIndex = null;
    public $activeSubIndex = null;
    public $possibleErrors = [];

    protected $listeners = ['tabClicked', 'tabSubClicked', 'periodChange'];

    abstract public function table(): string;

    abstract protected function title(): string;

    public function mount($model, $period)
    {
        $this->model = $model;
        $this->period = $period;
        $this->title = $this->title();

        $data = $this->data()->map(function ($item) {
            $item->json_result = json_decode($item->json_result, true);

            return (array) $item;
        })->toArray();

        $this->extractNavbar($data);
        $this->extractTables($data);
    }

    public function tabClicked($key)
    {
        $this->activeIndex = $key;
    }

    public function tabSubClicked($key)
    {
        $this->activeSubIndex = $key;
    }

    public function render()
    {
        return view('livewire.base-metrics');
    }

    protected function data(): Collection
    {
        return DB::connection('pgsql-xbrl')
            ->table('public.' . $this->table())
            ->select('json_result')
            ->where('symbol', '=', $this->model->symbol)
            ->where('is_annual_report', '=', $this->period === 'annual')
            ->orderBy('date', 'desc')
            ->get();
    }

    protected function extractNavbar($data)
    {
        $data = data_get($data, '0.json_result', []);

        $navbar = [];

        foreach ($data as $groups) {
            foreach ($groups as $key => $value) {
                $navbar[$key] = [
                    'id' => $key,
                    'title' => Str::title(preg_replace('/(?<=\w)(?=[A-Z])/', ' ', $key)),
                    'child' => [],
                ];

                $this->activeIndex = $this->activeIndex ?: $key;

                foreach ($value as $sub => $_) {
                    $id = $key . "-" . $sub;

                    $this->activeSubIndex = $this->activeSubIndex ?: $id;

                    $navbar[$key]['child'][] = [
                        'id' => $id,
                        'title' => Str::title(preg_replace('/(?<=\w)(?=[A-Z])/', ' ', $sub)),
                    ];
                }
            }
        }

        $this->navbar = $navbar;
    }

    protected function extractTables($data)
    {
        $tables = [];

        foreach ($data as $item) {
            $result = $item['json_result'];

            foreach ($result as $date => $level_0_value) {
                foreach ($level_0_value as $parentTab => $level_1_value) {
                    foreach ($level_1_value as $childTab => $level_2_value) {
                        $key = $parentTab . "-" . $childTab;

                        if (!isset($tables[$key])) {
                            $tables[$key] = [
                                'metrics' => [],
                                'segments' => [],
                                'possibleErrors' => [],
                            ];
                        }

                        foreach ($level_2_value as $segment => $value) {
                            if (is_float($value)) {
                                $value = (string) $value;

                                if (str_contains($value, "E+")) {
                                    $tables[$key]['possibleErrors'][] = [
                                        'date' => $date,
                                        'segment' => $segment,
                                        'value' => $value,
                                    ];
                                }
                            }

                            $value = is_float($value) ? (string) $value : $value;

                            $tables[$key]['metrics'][$date][$segment] = [
                                'data' => [
                                    'symbol' => $this->model->symbol,
                                    'source' => 'public.' . $this->table(),
                                    'date' => $date,
                                    'value' => $value,
                                ],
                                'value' => $value
                            ];

                            if (!isset($tables[$key]['segments'][$segment])) {
                                $tables[$key]['segments'][$segment] = Str::title(preg_replace('/(?<=\w)(?=[A-Z])/', ' ', $segment));
                            }
                        }
                    }
                }
            }
        }

        foreach ($tables as $key => $table) {
            $possibleErrors = $table['possibleErrors'];

            unset($table['possibleErrors']);

            $tables[$key]['message'] = null;
            
            if (!count($possibleErrors)) {
                continue;
            }

            $tables[$key]['message'] = view('partials.invalid-data', [
                'errors' => $possibleErrors,
            ])->render();
        }

        $this->tables = $tables;
    }
}
