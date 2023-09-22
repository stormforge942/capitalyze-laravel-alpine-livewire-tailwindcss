<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class OtcMetrics extends Component
{
    public $otc;
    public $table;
    private $metrics;
    private $segments;
    public $navbar;
    public $period;
    public $activeIndex = null;
    public $activeSubIndex = null;
    private $currentNavbar = '';

    protected $listeners = ['tabClicked', 'tabSubClicked', 'periodChange'];

    public function getMetrics()
    {
        $dbResponse = DB::connection('pgsql-xbrl')
            ->table('public.otc_statements')
            ->select('json_result')
            ->where('symbol', '=', $this->otc->symbol)
            ->where('is_annual_report', '=', $this->period === 'annual')
            ->orderBy('date', 'desc')
            ->get()->toArray();

        $cols = [];
        $rows = [];

        $this->currentNavbar = substr($this->activeSubIndex, strpos($this->activeSubIndex, "-") + 1);

        foreach ($dbResponse as $dbData) {
            $data = json_decode($dbData->json_result, true);
            foreach ($data as $date => $valueLevel0) {
                $cols[$date] = [];
                foreach ($valueLevel0 as $valueLevel1) {
                    foreach ($valueLevel1 as $keyLevel2 => $valueLevel2) {
                        foreach ($valueLevel2 as $keyLevel3 => $valueLevel3) {
                            $cols[$date][$keyLevel3] = $valueLevel3;
                            if ($this->currentNavbar == $keyLevel2) {
                                if (!in_array($keyLevel3, $rows, true)) {
                                    $rows[] =  $keyLevel3;
                                }
                            }
                        }
                    }
                }
            }
        }

        $this->metrics = $cols;
        $this->segments = $rows;
    }

    public function getNavbar()
    {
        $data = json_decode(DB::connection('pgsql-xbrl')
            ->table('public.otc_statements')
            ->where('symbol', '=', $this->otc->symbol)
            ->value('json_result'), true);


        $navbar = [];

        foreach ($data as $groups) {
            foreach ($groups as $key => $value) {
                $navbar[$key] = [];
                $this->activeIndex = ($this->activeIndex == null) ? $key : $this->activeIndex;
                foreach ($value as $sub => $_) {
                    $id = $key . "-" . $sub;
                    $this->activeSubIndex = ($this->activeSubIndex == null) ? $id : $this->activeSubIndex;
                    $navbar[$key][] = ['id' => $id, 'title' => $sub, 'selected' => ($id == $this->activeSubIndex)];
                }
            }
        }

        $this->navbar = $navbar;
        $this->emit('navbarUpdated', $this->navbar, $this->activeIndex, $this->activeSubIndex);
    }

    public function renderTable()
    {
        $i = 0;
        $class = '';
        $possibleErrors = [];
        $table = '<table class="table-auto min-w-full data border-collapse"><thead><tr>';
        $table .= '<th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900 bg-blue-300">Date</th>';
        foreach (array_keys($this->metrics) as $date) {
            $table .= '<th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-slate-950 bg-blue-300">' . $date . '</th>';
        }
        $table .= '</thead><tbody class="divide-y bg-white">';
        foreach ($this->segments as $segment) {
            $class = ($i % 2 == 0) ? 'class="border border-slate-50 bg-cyan-50 hover:bg-blue-200 dark:bg-slate-700 dark:odd:bg-slate-800 dark:odd:hover:bg-slate-900 dark:hover:bg-slate-700"' : 'class="border border-slate-50 bg-white border-slate-100 dark:border-slate-400 hover:bg-blue-200 dark:bg-slate-700 dark:odd:bg-slate-800 dark:odd:hover:bg-slate-900 dark:hover:bg-slate-700"';
            $table .= '<tr ' . $class . '><td class="break-words max-w-[150px] lg:max-w-[400px] px-2 py-2 text-sm text-gray-900 font-bold">' . preg_replace('/(?<=\w)(?=[A-Z])/', ' ', $segment) . '</td>';

            foreach (array_keys($this->metrics) as $date) {
                if (array_key_exists($segment, $this->metrics[$date])) {
                    $data = $this->metrics[$date][$segment];

                    if (is_float($data) && str_contains((string) $data, "E+")) {
                        $possibleErrors[] = [
                            'date' => $date,
                            'segment' => $segment,
                            'value' => $data,
                        ];
                    }

                    $dataSend = array("symbol" => $this->otc->symbol, "source" => 'public.otc_statements', "date" => $date, "value" => $data);
                    $data_json = json_encode($dataSend);
                    $table .= '<td data-value="' . htmlspecialchars($data_json) . '" class="whitespace-nowrap px-2 py-2 text-sm text-gray-900 hover:cursor-pointer hover:underline underline-offset-1 open-slide">' . $data . '</td>';
                } else {
                    $table .= '<td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900"></td>';
                }
            }

            $table .= '</tr>';
            $i++;
        }
        $table .= '</tbody></table>';

        $this->table = $table;

        if (count($possibleErrors)) {
            $this->dispatchBrowserEvent('showinfomodal', [
                'html' => view('modals.invalid-data', ['errors' => $possibleErrors])->render(),
            ]);
        }
    }

    public function mount($otc, $period)
    {
        $this->otc = $otc;
        $this->period = $period;
        $this->getNavbar();
        $this->getMetrics();
        $this->renderTable();
    }

    public function tabClicked($key)
    {
        $this->activeIndex = $key;
        $this->getMetrics();
        $this->renderTable();
    }

    public function tabSubClicked($key)
    {
        $this->activeSubIndex = $key;
        $this->getMetrics();
        $this->renderTable();
    }

    public function render()
    {
        return view('livewire.otc-metrics');
    }
}
