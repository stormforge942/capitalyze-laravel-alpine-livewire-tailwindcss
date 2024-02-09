<?php

namespace App\Http\Livewire\Slides;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LeftSlide extends Component
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
    public $open = false;

    protected $listeners = [
        'left-slide.open' => 'open',
        'loadData',
        'closeSlide'
    ];

    public function closeSlide()
    {
        $this->open = false;
    }

    public function open($data)
    {
        $this->ticker = $data['ticker'] ?? '';
        $this->value = $data['value'];
        $this->hash = $data['hash'];
        $this->secondHash = $data['secondHash'] ?? null;

        $this->open = true;
        $this->loaded = false;
    }

    public function key()
    {
        return $this->ticker . $this->hash . $this->secondHash . $this->value . ($this->loaded ? 'loaded' : 'not-loaded');
    }

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
            } else {
                $this->data = null;
            }

            $this->loaded = true;
        }
    }

    public function render()
    {
        return view('livewire.slides.left-slide');
    }
}
