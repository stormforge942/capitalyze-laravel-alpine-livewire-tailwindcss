<?php

namespace App\Http\Livewire;

use WireElements\Pro\Components\SlideOver\SlideOver;
use Illuminate\Support\Facades\DB;

class CompanyReportSlide extends SlideOver
{
    public $hash;
    public $secondHash;
    public $data;
    public $result;
    public $value;
    public $ticker;
    public $json;
    public $title = "Report Info";
    public $period = "";
    public $loaded = false;

    public function loadData()
    {
        if ($this->secondHash) {
            $result = DB::connection('pgsql-xbrl')
                ->table('public.tikr_text_block_content')
                ->where('ticker', '=', $this->ticker)
                ->where('fact_hash', '=', $this->secondHash)
                ->value('content');

            $this->result = json_decode($result, true);
        }

        if ($this->hash) {
            $query = DB::connection('pgsql-xbrl')
                ->table('public.info_idx_tb')
                ->where('ticker', '=', $this->ticker)
                ->where('info', 'ilike', '%' . $this->hash . '%')
                ->value('info');

            $decodedQuery = json_decode($query, true); // Decoding JSON into an associative array

            $keyToFind = $this->hash;

            if (isset($decodedQuery[$keyToFind])) {
                $factHashes = $decodedQuery[$keyToFind];

                $this->data = DB::connection('pgsql-xbrl')
                    ->table('public.as_reported_sec_text_block_content')
                    ->where('ticker', '=', $this->ticker)
                    ->whereIn('fact_hash', $factHashes)
                    ->value('content');

                $this->loaded = true;
            } else {
                $this->data = ['No Data Available'];
                $this->loaded = true;
            }
        }
    }

    public function mount($ticker, $value, $hash = null, $secondHash = null)
    {
        $this->ticker = $ticker;
        $this->value = $value;
        $this->hash = $hash;
        $this->secondHash = $secondHash;
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
            'remove-state-on-close' => true,
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
