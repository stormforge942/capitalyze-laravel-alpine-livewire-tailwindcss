<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CompanyReport extends Component
{
    public $company;
    public $ticker;
    public $companyName;
    public $currentRoute;
    public $period;
    public $table;
    public $navbar;
    public $subnavbar;
    public $activeIndex = '';
    public $activeSubIndex = '';
    public $data;
    public $tableDates = [];
    public $noData = false;
    public $skipNext = false;
    public $view = 'Common Size';
    public $unitType = 'Millions';
    public $template = 'Standart';
    public $order = 'Latest on the Right';
    public $freezePanes = 'Top Row';
    public $decimal = '.00';
    protected $request;
    protected $rowCount = 0;

   protected $listeners = ['periodChange', 'tabClicked', 'tabSubClicked'];

   function findDates($array, &$dates) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                if (preg_match('/(\d{4})-\d{2}-\d{2}/', $key, $m)) {
                    $year = $m[1];
                    if (!in_array($key, $dates) && $year > 2016) {
                        $dates[] = $key;
                    }
                } else {
                    $this->findDates($value, $dates);
                }
            }
        }
    }

    function generateTableRows($array, $dates, $label = '', $depth = 0, $isBold = false) {
        $output = '';
        $dateValues = [];
        $boldClass = $isBold ? ' font-bold' : '';



        // If the current array contains any date values, store them in $dateValues
        foreach ($array as $key => $value) {
            if (preg_match('/\d{4}-\d{2}-\d{2}/', $key) && is_array($value)) {
                $dateValues[$key] = $value;
            }
        }

        // Only generate a row if the label is not empty and not '#segmentation'
        if (!empty($label) && !$this->skipNext && $label !== '#segmentation') {

            $class =  $boldClass;
            $output .= '<div class=" row ' . $class . '">';
            $output .= '<div class="cell">' . str_repeat("&nbsp; ", $depth) . $label . '</div>';

            foreach ($dates as $date) {
                if (isset($dateValues[$date])) {
                    $value = $dateValues[$date][0];
                    // Check if the value is in USD and format it
                    if (isset($dateValues[$date][1]) && $dateValues[$date][1] === 'USD') {

                        if(strpos($value, '|') !== false) {
                            $value = '$' . number_format(strstr($value, '|', true), 2);

                        } else {
                            $value = '$' . number_format($value, 2);
                        }


                    }
                    // Check if the value starts with '@@@'
                    if (substr($value, 0, 3) === '@@@') {
                        $hash = substr($value, 3).strstr($value, '|'); // Get the value minus the three @
                        // Add a specific class and a data-hash attribute and display an icon
                        $data = array("hash" => $hash, "ticker" => $this->ticker);
                        $data_json = json_encode($data);
                        $value = '<div class="open-slide cell" data-value="'.htmlspecialchars($data_json).'">
                        <svg class="w-5 h-5 mx-auto cursor-pointer open-slide" data-value="'.htmlspecialchars($data_json).'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path class="open-slide" data-value="'.htmlspecialchars($data_json).'" d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm15 2h-4v3h4V4zm0 4h-4v3h4V8zm0 4h-4v3h3a1 1 0 0 0 1-1v-2zm-5 3v-3H6v3h4zm-5 0v-3H1v2a1 1 0 0 0 1 1h3zm-4-4h4V8H1v3zm0-4h4V4H1v3zm5-3v3h4V4H6zm4 4H6v3h4V8z"></path>
                      </svg></div>';
                    } else if(strpos($value, '|') !== false) {
                        list($content, $hash) = explode("|", $dateValues[$date][0], 2);
                        $data = array("hash" => $hash, "ticker" => $this->ticker);
                        $data_json = json_encode($data);
                        $value = '<div data-value="'.htmlspecialchars($data_json).'" class="cell">' . strstr($value, '|', true) . '</div>';
                    } else {
                        list($content, $hash) = explode("|", $dateValues[$date][0], 2);
                        $data = array("hash" => $hash, "ticker" => $this->ticker, "value" => $value);
                        $data_json = json_encode($data);
                        $value = '<div data-value="'.htmlspecialchars($data_json).'" class="open-slide cell cursor-pointer hover:underline">' . $value . '</div>';
                    }
                    $output .= $value;
                } else {
                    $output .= '<div class="cell"></div>';
                }
            }

            $output .= '</div>'; // .row
            $this->rowCount++;
        }


        if($label === '#segmentation') {
            $label = 'Segmentation';
            $this->skipNext = true;
        } else {
            $this->skipNext = false;
        }
        // Recursively generate rows for children
        foreach ($array as $key => $value) {
            if (!preg_match('/\d{4}-\d{2}-\d{2}/', $key) && is_array($value)) {
                $newIsBold = $isBold;
                if ($key === '#segmentation') {
                    $newIsBold = true;
                }
                $output .= $this->generateTableRows($value, $dates, $key, $depth + 1, $newIsBold);
            }
        }

        return $output;
    }

    function generateTableFromNestedArray($data) {
        // Find all unique dates
        $this->rowCount = 0;
        $dates = [];

        $this->findDates($data, $dates);
        rsort($dates);
        $this->tableDates = $dates;
        // Start generating the table
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
        $this->generateTableFromNestedArray($data);
    }

    public function updatedPeriod() {
        $this->getData();
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
        if ($navbar === []) {
            $this->noData = true;
            return;
        }

        $this->activeIndex = 'Financial Statements [Financial Statements]';
        $this->activeSubIndex = $navbar[$this->activeIndex][0]['id'];
        $this->navbar = $navbar;
        $this->emit('navbarUpdated', $this->navbar, $this->activeIndex, $this->activeSubIndex);
   }

    public function mount(Request $request, $company, $ticker, $period)
    {
        $this->emit('periodChange', 'annual');
        $this->company  = $company;
        $this->ticker = $ticker;
        $this->period = $period;
        $this->companyName = $this->ticker;
        $companyData = @json_decode($this->company, true);
        if ($companyData && count($companyData) && is_array($companyData) && array_key_exists('name', $companyData))
            $this->companyName = $companyData['name'];
        $this->getNavbar();
        if ($this->noData === true) {
            return;
        }
        $this->getData();
        if (!$this->currentRoute) {
            $this->currentRoute = $request->route()->getName();
        }
    }

    public function periodChange($period) {
        $this->period = $period;
        $this->getNavbar();
        $this->getData();
    }

    public function tabClicked($key) {
        $this->activeIndex = $key;
        $this->getData();
    }

    public function tabSubClicked($key) {
        $this->activeSubIndex = $key;
        $this->getData();
    }

    public function render()
    {
        return view('livewire.company-report');
    }
}
