<?php

namespace App\Http\Livewire;

use WireElements\Pro\Components\SlideOver\SlideOver;
use Illuminate\Support\Facades\DB;

class CompanyReportSlide extends SlideOver
{
    public $hash;
    public $data;
    public $ticker;
    public $json;
    public $title = "Report Info";
    public $period = "";
    public $loaded = false;

    public function loadData()
    {
        $source = 'as_reported_sec_text_block_content';
        $data = DB::connection('pgsql-xbrl')
        ->table($source)
        ->where('ticker', '=', $this->ticker)
        ->where('fact_hash', '=', $this->hash)
        ->value('content');

        $this->data = $data;
        $this->loaded = true;
    }

    public function mount($hash, $ticker) {
        $this->hash = $hash;
        $this->ticker = $ticker;
    }

    public function render()
    {
        return view('livewire.company-report-slide');
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
