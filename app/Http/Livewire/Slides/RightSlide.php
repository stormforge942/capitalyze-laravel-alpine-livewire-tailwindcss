<?php

namespace App\Http\Livewire\Slides;

use Illuminate\Support\Facades\DB;
use WireElements\Pro\Components\SlideOver\SlideOver;

class RightSlide extends SlideOver
{
    public $hash;
    public $secondHash;
    public $data = null;
    public $result = null;
    public $value;
    public $ticker;
    public $title = "Report Info";
    public $period = "";
    public $loaded = false;

    public function mount($data)
    {
        $this->ticker = $data['ticker'];
        $this->value = $data['value'];
        $this->hash = $data['hash'];
        $this->secondHash = $data['secondHash'] ?? null;
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
        return view('livewire.slides.right-slide');
    }

    public static function behavior(): array
    {
        return [
            'close-on-escape' => true,
            'close-on-backdrop-click' => true,
            'trap-focus' => true,
            'remove-state-on-close' => false,
        ];
    }

    public static function attributes(): array
    {
        return [
            'size' => 'xl',
        ];
    }
}
