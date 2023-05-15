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
    public $table;
    public $navbar;
    public $subnavbar;
    public $activeIndex = '';
    public $activeSubIndex = '';
    public $data;
    protected $request;
    protected $rowCount = 0;

   protected $listeners = ['periodChange', 'tabClicked', 'tabSubClicked'];

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
        if (!empty($label) && $label !== '#segmentation') {
            $bgClass = $this->rowCount % 2 === 0 ? 'bg-cyan-50' : 'bg-white'; // Change $depth to $rowCount here
            $class = $bgClass . ' hover:bg-blue-200' . $boldClass;
            $output .= '<tr class="' . $class . '">';
            $output .= '<td class="sticky left-0 py-2 break-words max-w-[150px] lg:max-w-[400px] text-sm '.$bgClass.'">' . str_repeat('&nbsp;', $depth) . $label . '</td>';
            
            foreach ($dates as $date) {
                if (isset($dateValues[$date])) {
                    $value = $dateValues[$date][0];
                    // Check if the value is in USD and format it
                    if (isset($dateValues[$date][1]) && $dateValues[$date][1] === 'USD') {
                        $value = '$' . number_format($value, 2);
                    }
                    // Check if the value starts with '@@@'
                    if (substr($value, 0, 3) === '@@@') {
                        $hash = substr($value, 3); // Get the value minus the three @
                        // Add a specific class and a data-hash attribute and display an icon
                        $data = array("hash" => $hash, "ticker" => $this->ticker);
                        $data_json = json_encode($data);
                        $value = '<td class="open-slide" data-value="'.htmlspecialchars($data_json).'">
                        <svg class="w-5 h-5 mx-auto cursor-pointer open-slide" data-value="'.htmlspecialchars($data_json).'" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path class="open-slide" data-value="'.htmlspecialchars($data_json).'" d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm15 2h-4v3h4V4zm0 4h-4v3h4V8zm0 4h-4v3h3a1 1 0 0 0 1-1v-2zm-5 3v-3H6v3h4zm-5 0v-3H1v2a1 1 0 0 0 1 1h3zm-4-4h4V8H1v3zm0-4h4V4H1v3zm5-3v3h4V4H6zm4 4H6v3h4V8z"></path>
                      </svg></td>';
                    } else {
                        $value = '<td class="border-slate-400 p-2 text-sm">' . $value . '</td>';
                    }
                    $output .= $value;
                } else {
                    $output .= '<td></td>';
                }
            }
    
            $output .= '</tr>';
            $this->rowCount++;
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

        // Start generating the table
        $output = '<table class="table-auto min-w-full data-report">';
        $output .= '<thead>';
        $output .= '<tr>';
        $output .= '<th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900 bg-blue-300">Date</th>';
        foreach ($dates as $date) {
            $output .= '<th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900 bg-blue-300">' . $date . '</th>';
        }
        $output .= '</tr>';
        $output .= '</thead>';

        $output .= '<tbody class="divide-y bg-white">';
        $output .= $this->generateTableRows($data, $dates, '', 0);
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

        $this->activeIndex = 'Financial Statements [Financial Statements]';
        $this->activeSubIndex = $navbar[$this->activeIndex][0]['id'];
        $this->navbar = $navbar;
        $this->emit('navbarUpdated', $this->navbar, $this->activeIndex, $this->activeSubIndex);
   }

    public function mount($company, $ticker, $period)
    {
        $this->emit('periodChange', 'annual');
        $this->company  = $company;
        $this->ticker = $ticker;
        $this->period = $period;
        $this->getNavbar();
        $this->getData();
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
