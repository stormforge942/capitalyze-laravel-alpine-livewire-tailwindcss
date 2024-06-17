<?php

namespace App\Http\Livewire\Slides;

use Illuminate\Support\Js;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
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
    public $loaded = false;
    public $isLink = false;
    public $decimalPlaces = 3;

    public function mount($data)
    {
        $this->ticker = $data['ticker'];
        $this->value = $data['value'];
        $this->hash = $data['hash'];
        $this->secondHash = $data['secondHash'] ?? null;
        $this->isLink = $data['isLink'] ?? false;
    }

    public function loadData()
    {
        if ($this->secondHash) {
            $cacheKey = 'right_slide_secondHash_' . $this->ticker . '_' . $this->secondHash;

            $this->result = Cache::remember($cacheKey, 3600, function () {
                $result = DB::connection('pgsql-xbrl')
                    ->table('public.tikr_text_block_content')
                    ->where('ticker', '=', $this->ticker)
                    ->where('fact_hash', '=', $this->secondHash)
                    ->value('content');

                return json_decode($result, true);
            });
        }

        if ($this->hash) {
            $cacheKey = 'company_report_slide_' . $this->ticker . '_' . $this->hash . '_' . $this->isLink ? 'link' : 'hash';

            $this->data = Cache::remember($cacheKey, 3600, $this->getData(...));
        }

        $this->loaded = true;
    }

    public function render()
    {
        return view('livewire.slides.right-slide');
    }

    private function getData()
    {
        if ($this->isLink) {
            $hashes = [$this->hash];
        } else {
            $query = DB::connection('pgsql-xbrl')
                ->table('public.info_idx_tb')
                ->where('ticker', '=', $this->ticker)
                ->where('info', 'ilike', '%' . $this->hash . '%')
                ->value('info');

            $decodedQuery = json_decode($query, true); // Decoding JSON into an associative array

            $keyToFind = $this->hash;

            $hashes = $decodedQuery[$keyToFind] ?? [];
        }

        if (!count($hashes)) return null;

        return DB::connection('pgsql-xbrl')
            ->table('public.as_reported_sec_text_block_content')
            ->where('ticker', '=', $this->ticker)
            ->whereIn('fact_hash', $hashes)
            ->pluck('content')
            ->implode('<br>');
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

    public function transformHint(string $text, array $hashMapping): string
    {
        foreach ($hashMapping as $key => $item) {
            if (!$item) continue;

            $value = !isset($item[0]) || $item[0] === "-" ? null : $item[0];

            $data = Js::from([
                'ticker' => $this->ticker,
                'value' => $value,
                'hash' => $item[1],
            ]);

            $text = str_replace('[' . $key . ']', '[<button class="sub-arg-btn inline-block cursor-pointer rounded bg-gray-200 hover:bg-gray-300 transition-colors" style
            ="padding: 0.2px 2px; margin: 0 1px;" @click="Livewire.emit(\'left-slide.open\', ' . $data . ')">' . $key . '</button>]', $text);
        }

        return $text;
    }

    public function resolvedExpression(string $text, array $hashMapping): string
    {
        foreach ($hashMapping as $key => $item) {
            if (!$item) continue;

            $value = !isset($item[0]) || is_null($item[0]) || $item[0] === "-" ? 0 : $item[0];

            $text = str_replace('[' . $key . ' ', $value, $text);
            $text = str_replace(' ' . $key . ']', $value, $text);
            $text = str_replace('[' . $key . ']', $value, $text);
            $text = str_replace(' ' . $key . ' ', $value, $text);
        }

        $text = preg_replace(
            '/\(?-(\d+)\)?/',
            '<span class="text-red-500">($1)</span>',
            $text
        );

        return $text;
    }

    public static function attributes(): array
    {
        return [
            'size' => '3xl',
        ];
    }
}
