<?php

namespace App\Http\Livewire\InsiderTransactions;

use Illuminate\Support\Facades\DB;
use WireElements\Pro\Components\SlideOver\SlideOver;

class Form extends SlideOver
{
    public string $symbol;
    public string $url;
    public ?int $quantity = null;
    private string $content = '';

    public function render()
    {
        return view('livewire.insider-transactions.form', [
            'content' => $this->content
        ]);
    }

    public function load()
    {
        $data = DB::connection('pgsql-xbrl')
            ->table('company_links')
            ->where('symbol', $this->symbol)
            ->where('final_link', $this->url)
            ->first();

        $this->content =  $data?->s3_link ? (file_get_contents($data->s3_link) ?? '') : '';
    }

    public static function attributes(): array
    {
        return [
            'size' => '6xl',
        ];
    }
}
