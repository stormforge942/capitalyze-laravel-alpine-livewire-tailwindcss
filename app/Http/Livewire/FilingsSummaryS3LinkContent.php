<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use WireElements\Pro\Components\SlideOver\SlideOver;

class FilingsSummaryS3LinkContent extends SlideOver
{
    public string $cik;
    public string $date;
    public string $name_of_issuer;
    public ?string $url = null;

    public function updatedPage()
    {
        $this->load();
    }

    public function render()
    {
        return view('livewire.filings-summary-s3-link-content');
    }

    public function load()
    {
        $this->url = DB::connection('pgsql-xbrl')
            ->table('filings_summary')
            ->where([
                'cik' => $this->cik,
                'date' => $this->date,
            ])
            ->value('s3_url');
    }

    public static function attributes(): array
    {
        return [
            'size' => '6xl',
        ];
    }
}
