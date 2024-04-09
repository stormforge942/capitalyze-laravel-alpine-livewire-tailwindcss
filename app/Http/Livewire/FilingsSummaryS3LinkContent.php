<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use WireElements\Pro\Components\SlideOver\SlideOver;

class FilingsSummaryS3LinkContent extends SlideOver
{
    public string $cik;
    public string $date;
    public string $content = '';

    public function render()
    {
        return view('livewire.filings-summary-s3-link-content');
    }

    public function load()
    {
        $url = DB::connection('pgsql-xbrl')
            ->table('filings_summary')
            ->where([
                'cik' => $this->cik,
                'date' => $this->date,
            ])
            ->value('s3_url');

        // if file size is greater than 1MB, display message
        $size = data_get(get_headers($url, true), 'Content-Length', PHP_INT_MAX);
        if ($size > (1024 * 1024 * 1)) {
            $this->content = 'File too large to display. Click on the <a class="text-blue hover:underline font-medium" href="' . $url . '" target="_blank">link</a> to download.';
            return;
        }

        $this->content = file_get_contents($url);
    }

    public static function attributes(): array
    {
        return [
            'size' => '4xl',
        ];
    }
}
