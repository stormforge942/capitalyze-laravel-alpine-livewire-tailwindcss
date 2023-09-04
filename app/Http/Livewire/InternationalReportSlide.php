<?php

namespace App\Http\Livewire;

use WireElements\Pro\Components\SlideOver\SlideOver;
use Illuminate\Support\Facades\DB;

class InternationalReportSlide extends SlideOver
{
    public $data;
    public $symbol;
    public $source;
    public $date;
    public $title = "Report Info";
    public $loaded = false;

    public function loadData()
    {
        $query = DB::connection('pgsql-xbrl')
        ->table($this->source)
        ->where('symbol', '=', $this->symbol)
        ->where('date', '=', $this->date)
        ->value('html_data');

        if (isset($query)) {
            if (is_array($query)) {
                foreach($query as $table) {
                    $this->data[] = $table;        
                }
            } else {
                $this->data = [$query];
            }
            
            $this->loaded = true;
        } else {
            $this->data = ['No Data Available'];
            $this->loaded = true;
        }
    }

    public function mount($symbol, $source) {
        $this->symbol = $symbol;
        $this->source = $source;
    }

    public function render()
    {
        return view('livewire.international-report-slide');
    }

    public static function behavior(): array
    {
        return [
            // Close the slide-over if the escape key is pressed
            'close-on-escape' => true,
            // Close the slide-over if someone clicks outside the slide-over
            'close-on-backdrop-click' => true,
            // Trap the users focus inside the slide-over (e.g. input autofocus and going back and forth between input fields)
            'trap-focus' => true,
            // Remove all unsaved changes once someone closes the slide-over
            'remove-state-on-close' => false,
        ];
    }
 
    public static function attributes(): array
    {
        return [
            // Set the slide-over size to 2xl, you can choose between:
            // xs, sm, md, lg, xl, 2xl, 3xl, 4xl, 5xl, 6xl, 7xl
            'size' => 'xl',
        ];
    }
}
