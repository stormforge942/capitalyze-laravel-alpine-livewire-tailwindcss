<?php

namespace App\Http\Livewire;

use App\Models\Company;
use App\Models\InfoPresentation;
use Carbon\Carbon;
use Illuminate\Database\ConnectionResolver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CompanyReport extends Component
{
    use TableFiltersTrait;


    public $rows = [];
    public $company;
    public $decimalDisplay = '0';
    public $ticker;
    public $chartData = [];
    public $companyName;
    public $unitType = 'Thousands';
    public $currentRoute;
    public $order = "Latest on the Right";
    public $period;
    public $table;
    public $navbar;
    public $subnavbar;
    public $reverse = false;
    public $activeIndex = '';
    public $activeSubIndex = '';
    public $data;
    public $tableDates = [];
    public $noData = false;
    public $tableLoading = true;

    protected $request;
    protected $rowCount = 0;
    public $selectedRows = [];

   protected $listeners = ['periodChange', 'tabClicked', 'tabSubClicked', 'selectRow', 'unselectRow'];

   public function selectRow($title, $data){
       $this->selectedRows[$title] = $data;

       $this->generateChartData();
       $this->emit('initCompanyReportChart');
   }

   public function regenareteTableChart(): void
   {
       $this->generateUI();
   }

   public function unselectRow($title)
   {
       unset($this->selectedRows[$title]);
       if (count($this->selectedRows)){
         $this->generateChartData(true);
       } else {
            $this->chartData = [];
            $this->emit('hideCompanyReportChart');
       }
   }

   public function toggleReverse() {
       $this->reverse = !$this->reverse;
       $this->regenareteTableChart();
   }

   public function generateChartData($initChart = false): void
   {
       $chartData = [];

       foreach ($this->selectedRows as $title => $row) {
           $data = [];
           foreach ($row as $cell) {
               if (!$cell['empty']) {
                   $data[] = [
                       'y' => $cell['value'],
                       'x' => $cell['date'],
                   ];
               } else {
                   $data[] = [
                       'y' => null,
                       'x' => null,
                   ];
               }
           }


           $chartData[] = [
               'data' => $data,
               'type' => 'line',
               'label' => $title,
               'borderColor' => '#000',
               'pointRadius' => 1,
               'pointHoverRadius' => 8,
               'tension' => 0.5,
               'pointHoverBorderColor' => '#fff',
               'pointHoverBorderWidth' => 4,
               'pointHoverBackgroundColor' => 'rgba(104, 104, 104, 0.87)'
           ];
       }

         $this->chartData = $chartData;

       if ($initChart) {
           $this->emit('initCompanyReportChart');
       }
   }

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
        // if (!empty($label) && !$this->skipNext ) {
        if (!empty($label) ) {

            $class =  $boldClass;
            $padding = $depth * 10; // Assuming 20 pixels of padding per depth level

            $output .= '<div class=" row ' . $class . '">';
            $output .= '<div class="cell" style="padding-left: ' . $padding . 'px;">' . $label . '</div>';


            // if($label != "Net sales" && $label != "#segmentation") {
            //     dd($output);
            // }

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
                        [$content, $hash] = explode("|", $dateValues[$date][0], 2);
                        $data = array("hash" => $hash, "ticker" => $this->ticker);
                        $data_json = json_encode($data);
                        $value = '<div data-value="'.htmlspecialchars($data_json).'" class="cell">' . strstr($value, '|', true) . '</div>';
                    } else {
                        [$content, $hash] = explode("|", $dateValues[$date][0], 2);
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


        // if($label === '#segmentation') {
        //     $label = 'Segmentation';
        //     $this->skipNext = true;
        // } else {
        //     $this->skipNext = false;
        // }
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
        $this->table = $this->generateTableRows($data, $dates, '', 0);
    }

    public function getData() {
        $acronym = ($this->period == 'annual') ? 'arf5drs' : 'qrf5drs';

        $defaultConnectionName = DB::getDefaultConnection();
        $defaultConnectionResolver = new ConnectionResolver();
        $defaultConnectionResolver->addConnection(
            $defaultConnectionName,
            DB::connection($defaultConnectionName),
        );
        $defaultConnectionResolver->setDefaultConnection($defaultConnectionName);

        $remoteConnectionName = 'pgsql-xbrl';
        $remoteConnectionResolver = new ConnectionResolver();
        $remoteConnectionResolver->addConnection(
            $remoteConnectionName,
            DB::connection($remoteConnectionName),
        );
        $remoteConnectionResolver->setDefaultConnection($remoteConnectionName);

        DB::setDefaultConnection($remoteConnectionName);
        Model::setConnectionResolver($remoteConnectionResolver);

        $query = InfoPresentation::query()
            ->where('ticker', '=', $this->ticker)
            ->where('acronym', '=', $acronym)
            ->where('id', '=', $this->activeSubIndex)
            ->select('info')->value('info');

        Model::setConnectionResolver($defaultConnectionResolver);
        DB::setDefaultConnection($defaultConnectionName);

        $data = json_decode($query, true);
        $this->data = $data;
        $this->generateUI();
    }

    public function closeChart() {
        $this->chartData = [];
        $this->selectedRows = [];
        $this->emit('hideCompanyReportChart');
    }

    public function changeDates($dates) {
       $this->tableLoading = true;
       $this->rows = [];
        if (count($dates) == 2) {
            $this->tableDates = [];
            for($i = $dates[0]; $i <= $dates[1]; $i++) {
                $this->tableDates[] = $i;
            }
        }

//        if ($this->order != "Latest on the Right") {
//            $this->tableDates = array_reverse($this->tableDates);
//        }

        $this->generateRows($this->data);
        if (count($this->selectedRows)){
            $this->generateChartData();
            $this->emit('initCompanyReportChart');
        }
        $this->tableLoading = false;
    }

    public function generateUI(): void
    {
        $this->generateTableDates();
        $this->generateRows($this->data);
    }

    function traverseArray($array) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                if (strtotime($key) !== false) {
                    $this->tableDates[] = date('Y', strtotime($key));
                }
                $this->traverseArray($value);
            } else {
                break;
            }
        }
    }

    public function generateTableDates()
    {
        $this->traverseArray($this->data);

        $dates = [];
        $minYear = (int) min(array_unique($this->tableDates));
        $maxYear = (int) max(array_unique($this->tableDates));

        for ($i = 0; $minYear + $i <= $maxYear; $i++) {
            $year = $minYear + $i;
            $dates[] = $year;
        }

        $this->tableDates = $dates;
    }

    public function generateRows($data) {
       $this->tableLoading = true;
       $rows = [];

       $index = 0; // Initialize the index

        foreach($data as $key => $value) {
    
            if($index == 0 && $key == 'Income Statement') {


                
                $keyn = array_keys($data[$key])[0];
                $valuen = $data[$key][$keyn];
                $keynn = array_keys($valuen)[0];
                $valuenn = $valuen[$keynn];

                $rows[] = $this->generateRow($valuenn, $keynn);
                $index++; 
            } else {
                // $rows[] = $this->generateRow($value, $key);
            }
       }

       $this->rows = $rows;
       $this->tableLoading = false;
    }

    public function generateRow($data, $title):array {
        $row = [
            'title' => $title,
            'values' => $this->generateEmptyCellsRow(),
            'children' => [],
        ];

        foreach($data as $key => $value) {
            $isDate = true;
            try {
                Carbon::createFromFormat('Y-m-d', $key);
            } catch (\Exception $e) {
                $isDate = false;
            }


            if ($isDate) {
                $year = Carbon::createFromFormat('Y-m-d', $key)->year;
                if (in_array($year, $this->tableDates))
                {
                    $row['values'][$year] = $this->parseCell($value, $key);
                }
            } else {
                if (in_array($key, ['#segmentation'])) {
                    foreach($value as $sKey => $sValue) {
                        $keyn = array_keys($value[$sKey])[0];
                        $valuen = $sValue[$keyn];
                        $keynn = array_keys($valuen)[0];
                        $valuenn = $valuen[$keynn];
                        $row['children'][] = $this->generateRow($valuenn, $keynn);
                    }
                } else {
                    $row['children'][] = $this->generateRow($value, $key);
                }
            }

        }

        return $row;
    }

    public function generatePresent($value)
    {
        $unitType = $this->unitType;
        $units = [
            'Thousands' => 'T',
            'Millions' => 'M',
            'Billions' => 'B',
        ];

        $decimalDisplay = intval($this->decimalDisplay);

        if (!isset($units[$unitType])) {
            return number_format($value, $decimalDisplay);
        }

        $unitAbbreviation = $units[$unitType];

        // Determine the appropriate unit based on the number
        if ($unitAbbreviation == 'B') {
            return number_format($value / 1000000000);
        } elseif ($unitAbbreviation == 'M') {
            return number_format($value / 1000000);
        } elseif ($unitAbbreviation == 'T') {
            return number_format($value / 1000);
        } else {
            return number_format($value);
        }
    }

    public function parseCell($data, $key) : array
    {
       $response = [];
       $response['empty'] = false;
       $response['date'] = $key;
       $response['ticker'] = $this->ticker;

         foreach($data as $key => $value) {
              if (in_array('|', str_split($value))) {
                  [$value, $hash] = explode('|', $value);
                $response['value'] = $value;
                $response['present'] = $this->generatePresent($value);
                $response['hash'] = $hash;
              } else {
                $response[$key] = $value;
              }
         }

         return $response;
    }

    public function generateEmptyCellsRow(): array
    {
        $response = [];

        foreach ($this->tableDates as $date) {
            $response[$date] = [
                'date' => Carbon::createFromFormat('Y', $date)->format('Y-m-d'),
                'value' => '',
                'hash' => '',
                'ticker' => $this->ticker,
                'empty' => true,
            ];
        }

        return $response;
    }

    public function updated($propertyName): void
    {
        if (
            $propertyName === 'unitType'
            || $propertyName === 'order'
            || $propertyName === 'decimalDisplay'
        ) {
            $this->regenareteTableChart();
        }
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
