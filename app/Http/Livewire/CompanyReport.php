<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class CompanyReport extends Component
{
    public $company;
    public $ticker;
    public $period;
    public $metrics;
    public $segments;
    public $table;
    public $faces;
    public $parentFace = 'face';
    public $currentFace = 'Incomestatement';
    public $navbar;
    public $subnavbar;
    public $activeIndex = '';
    public $activeSubIndex = '';
    public $loaded = false;
    public $data;
    protected $request;
    private $rowNumber;

   protected $listeners = ['periodChange', 'reportChange', 'tabClicked', 'tabSubClicked'];

   public function __construct() {
        $this->rowNumber = 1;
    }

   function findDates($array, &$dates) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                if (preg_match('/\d{4}-\d{2}-\d{2}/', $key)) {
                    if (!in_array($key, $dates)) {
                        $dates[] = $key;
                    }
                } else {
                    $this->findDates($value, $dates);
                }
            }
        }
    }

    function generateTableRows($array, $dates, $label = '', $rowNumber = 1) {
        $output = '';
        $dateValues = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                if (preg_match('/\d{4}-\d{2}-\d{2}/', $key)) {
                    $dateValues[$key] = $value[0];
                } else {
                    $output .= $this->generateTableRows($value, $dates, $key);
                }
            }
        }
        if (!empty($dateValues)) {
            $class = $this->rowNumber % 2 == 0 ? 'border border-slate-50 bg-cyan-50 hover:bg-blue-200' : 'border border-slate-50 bg-white border-slate-100 hover:bg-blue-20';
            $output .= '<tr class="' . $class . '">';
            $output .= '<td>' . $label . '</td>';
            foreach ($dates as $date) {
                if (isset($dateValues[$date])) {
                    $output .= '<td>' . $dateValues[$date] . '</td>';
                } else {
                    $output .= '<td></td>';
                }
            }
            $output .= '</tr>';
            $this->rowNumber++;
        }
        return $output;
    }

   function generateTableFromNestedArray($data) {
    $this->rowNumber = 0;
    $array = $data;
    // Find all unique dates
    $dates = [];
    $this->findDates($array, $dates);
    rsort($dates);

    // Start generating the table
    $output = '<table class="table-auto min-w-full data">';
    $output .= '<thead>';
    $output .= '<tr>';
    $output .= '<th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900 bg-blue-300">Label</th>';
    foreach ($dates as $date) {
        $output .= '<th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900 bg-blue-300">' . $date . '</th>';
    }
    $output .= '</tr>';
    $output .= '</thead>';

    $output .= '<tbody class="divide-y bg-white">';
    $output .= $this->generateTableRows($array, $dates, '', 1);
    $output .= '</tbody>';
    $output .= '</table>';

    return $output;
  }

   public function getData() {
        $acronym = ($this->period == 'annual') ? 'arf5drs' : 'qrf5drs';
        $source = 'info_presentations';
        $query = DB::connection('pgsql-xbrl')
        ->table($source)
        ->where('ticker', '=', $this->ticker)
        ->where('acronym', '=', $acronym)
        ->where('id', '=', $this->activeSubIndex)
        ->value('info');

        $data = json_decode($query, true);
        $this->data = $data;
        $table = $this->generateTableFromNestedArray($data);
        $this->table = $table;
   }

   public function getNavbar() {
        $navbar = [];
        $acronym = ($this->period == 'annual') ? 'arf5drs' : 'qrf5drs';
        $source = 'info_presentations';
        $query = DB::connection('pgsql-xbrl')
        ->table($source)
        ->where('ticker', '=', $this->ticker)
        ->where('acronym', '=', $acronym)
        ->select('statement', 'statement_group', 'id', 'title')->get();

        $collection = $query->collect();
        
        foreach($collection as $value) {
            $navbar[$value->statement_group][] = ['statement' => $value->statement,'id' => $value->id, 'title' => $value->title];
        }

        $this->activeIndex = array_key_first($navbar);
        $this->activeSubIndex = $navbar[$this->activeIndex][0]['id'];
        $this->navbar = $navbar;
   }

   public function getReport() {
        $metrics = [];
        $dates = [];
        $segments = [];

        $metrics = array_keys($this->data);

        foreach($this->data as $date) {
            $key = array_key_first($date);
            $dates[] = $key;
            if(array_key_exists($this->navbar[$this->activeIndex], $date[$key])) {
                var_dump($this->navbar[$this->activeIndex]);
                if(array_key_exists($this->navbar[$this->activeIndex], $date[$key][$this->navbar[$this->activeIndex]])) {
                    $metrics[$key] = $date[$key][$this->parentFace][$this->currentFace];
                    $keys = array_keys($metrics[$key]);
                    foreach($keys as $subkey) {
                        if(!in_array($subkey, $segments, true)){
                            $segments[] =  $subkey;
                        }
                    }
                }
            }
        }

        $this->metrics = $metrics;
        $this->segments = $segments;
   }

   public function renderTable() {
        $i = 0;
        $class = '';
        $table = '<table class="table-auto min-w-full data"><thead><tr>';
        $table .= '<th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900 bg-blue-300">Segment</th>';
        foreach(array_keys($this->metrics) as $date) {
            $table .= '<th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900 bg-blue-300">'.$date.'</th>';
        }
        $table .= '</thead><tbody class="divide-y bg-white">';
        foreach($this->segments as $segment) {
            $class = ($i % 2 == 0) ? 'class="border border-slate-50 bg-cyan-50 hover:bg-blue-200 dark:bg-slate-700"' : 'class="border border-slate-50 bg-white border-slate-100 hover:bg-blue-200"';
            $table .= '<tr '.$class.'><td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900 font-bold">'.preg_replace('/(?<=\w)(?=[A-Z])/', ' ', $segment).'</td>';
            foreach(array_keys($this->metrics) as $date) {
                if(array_key_exists($segment, $this->metrics[$date])) {
                    $table .= '<td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900">'.$this->metrics[$date][$segment].'</td>';
                } else {
                    $table .= '<td class="whitespace-nowrap px-2 py-2 text-sm text-gray-900"></td>';
                }
            }
            $table .= '</tr>';
            $i++;
        }
        $table .= '</tbody></table>';

        $this->table = $table;
   }

    public function mount($company, $ticker, $period)
    {

        $this->company  = $company;
        $this->ticker = $ticker;
        $this->period = $period;
        $this->getNavbar();
        $this->getData();
    }

    public function reportChange($face, $parent)
    {
        $this->parentFace = $parent;
        $this->currentFace = $face;

        $this->renderFaces();
        $this->getReport();
        $this->renderTable();
    }

    public function periodChange($period) {
        $this->period = $period;
        $this->getReport();
        $this->renderTable();
    }

    public function tabClicked($key) {
        $this->activeIndex = $key;
        $this->getData();
    }

    public function tabSubClicked($key) {
        $this->activeSubIndex = $key;
        $this->getData();
    }

    public function loadData() {
        $this->getReport();
        $this->renderTable();
        $this->loaded = true;
    }

    public function render()
    {
        return view('livewire.company-report');
    }
}
