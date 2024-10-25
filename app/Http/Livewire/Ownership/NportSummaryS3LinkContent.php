<?php

namespace App\Http\Livewire\Ownership;

use Illuminate\Support\Facades\DB;
use WireElements\Pro\Components\SlideOver\SlideOver;

class NportSummaryS3LinkContent extends SlideOver
{
    public $fund;
    public $date;
    public $balance;
    public string $content = '';

    public function render()
    {
        return view('livewire.ownership.nport-summary-s3-link-content');
    }

    public function load()
    {
        $url = DB::connection('pgsql-xbrl')
            ->table('mutual_fund_holdings_summary')
            ->where([
                ...$this->fund,
                'date' => $this->date,
            ])
            ->value('ex_s3_url');

        $this->content = $url ? file_get_contents($url) : '';
    }

    public static function attributes(): array
    {
        return [
            'size' => '6xl',
        ];
    }
}
