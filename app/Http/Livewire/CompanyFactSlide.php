<?php

namespace App\Http\Livewire;

use WireElements\Pro\Components\SlideOver\SlideOver;
use Illuminate\Support\Facades\DB;

class CompanyFactSlide extends SlideOver
{
    public $hash;
    public $data;
    public $ticker;
    public $json;
    public $title = "Value Report";
    public $period = "";
    public $loaded = false;

    public function loadData()
    {
        $source = 'info_facts_data';
        $json = DB::connection('pgsql-xbrl')
        ->table($source)
        ->where('ticker', '=', $this->ticker)
        ->where('hash', '=', $this->hash)
        ->value('info');

        $data = json_decode($json, true);
        $this->json = $json;
        $this->data = $data;
        $this->loaded = true;
    }

    public function mount($hash, $ticker, $period) {
        $this->hash = $hash;
        $this->ticker = $ticker;
        $this->period = $period;
    }

    public function render()
    {
        $this->emit('Slideloaded');
        return view('livewire.company-fact-slide');
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
            'size' => '3xl',
        ];
    }
}
