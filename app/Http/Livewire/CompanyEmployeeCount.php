<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class CompanyEmployeeCount extends Component
{
    public $ticker;
    public $company;
    public $data;

    public function mount($ticker)
    {
        $this->ticker = $ticker;
    }

    public function getData()
    {
        // Get revenue
        $source = 'as_reported_sec_quarter_restated_api';
        $revenueData = DB::connection('pgsql-xbrl')
            ->table($source)
            ->where('ticker', '=', $this->ticker)
            ->value('api_return_with_unit');

        $revenueData = json_decode($revenueData, true);
        $revenue = [];
        $lastRevenueValue = null;

        foreach($revenueData as $date) {
            $key = array_key_first($date);

            if(array_key_exists('face', $date[$key]) && array_key_exists('Income Statement', $date[$key]['face'])) {
                
                if(array_key_exists('Revenue', $date[$key]['face']['Income Statement'])) {
                    $lastRevenueValue = $date[$key]['face']['Income Statement']['Revenue'][0];
                    $revenue[$key] = $lastRevenueValue;
                }
            }
        }

        // Get employee count
        $employeeCountData = DB::connection('pgsql-xbrl')
            ->table('employee_count')
            ->where('symbol', '=', $this->ticker)
            ->get();

        $data = [];

        foreach ($employeeCountData as $row) {
            $date = $row->period_of_report;
        
            // Only add the entry if an employee count is available and there is a revenue value for the date
            if ($row->count && array_key_exists($date, $revenue)) {
                $revenuePerEmployee = $revenue[$date] / $row->count;
        
                $data[$date] = [
                    'revenue_per_employee' => $revenuePerEmployee,
                    'employee_count' => $row->count
                ];
            }
        }

        $this->data = $data;
    }

    public function getChartData()
    {
        $chartData = [];

        foreach ($this->data as $date => $values) {
            $year = date('Y', strtotime($date));  // Convert date to year
            $chartData['labels'][] = $year;
            $chartData['employee_count'][] = $values['employee_count'];
            $chartData['revenue_per_employee'][] = $values['revenue_per_employee'];
        }

        $this->emit('renderRevenueEmployeeChart', $chartData);
    }


    public function render()
    {
        $this->getData();
        return view('livewire.company-employee-count', ['data' => $this->data]);
    }
}
