<?php

namespace App\Http\Livewire\Slides;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LeftSlide extends Component
{
    public $hash;
    public $data;
    public $value;
    public $ticker;
    public $title = "Report Info";
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

        $this->open = true;
        $this->loaded = false;
    }

    public function key()
    {
        return $this->ticker . $this->hash . $this->value . ($this->loaded ? 'loaded' : 'not-loaded');
    }

    public function loadData()
    {
        $cacheKey = 'company_report_slide_' . $this->ticker . '_' . $this->hash . '_' . 'hash';

        $this->data = Cache::remember($cacheKey, 3600, $this->getData(...));

        $this->loaded = true;
    }

    private function getData()
    {
        $query = DB::connection('pgsql-xbrl')
            ->table('public.info_idx_tb')
            ->where('ticker', '=', $this->ticker)
            ->where('info', 'ilike', '%' . $this->hash . '%')
            ->value('info');

        $decodedQuery = json_decode($query, true); // Decoding JSON into an associative array

        $keyToFind = $this->hash;

        $hashes = $decodedQuery[$keyToFind] ?? [];

        if (!count($hashes)) return null;

        return DB::connection('pgsql-xbrl')
            ->table('public.as_reported_sec_text_block_content')
            ->where('ticker', '=', $this->ticker)
            ->whereIn('fact_hash', $hashes)
            ->pluck('content')
            ->implode('<br>');
    }

    public function render()
    {
        return view('livewire.slides.left-slide');
    }
}
