<?php

namespace App\Http\Livewire\CompanyReport;

use Illuminate\Support\Facades\DB;
use WireElements\Pro\Components\Modal\Modal;

class ValueHtmlModal extends Modal
{
    public string $value;
    public string $ticker;
    public $loaded = false;
    public string $content = '';

    public function mount(string $value, string $ticker)
    {
        $this->value = $value;
        $this->ticker = $ticker;

        $this->content = '';
    }

    public function loadData()
    {
        $this->content = DB::connection('pgsql-xbrl')
            ->table('as_reported_sec_text_block_content')
            ->where('fact_hash', $this->value)
            ->where('ticker', $this->ticker)
            ->first()
            ?->content;

        $this->loaded = true;
    }

    public function render()
    {
        return view('livewire.company-report.value-html-modal');
    }

    public static function attributes(): array
    {
        return [
            'size' => '4xl',
        ];
    }
}
