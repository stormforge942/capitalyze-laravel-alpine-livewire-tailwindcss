<?php

namespace App\Http\Livewire\InsiderTransactions;

use WireElements\Pro\Components\SlideOver\SlideOver;

class Form extends SlideOver
{
    public ?string $sourceLink = null;
    private string $content = '';
    public ?int $quantity = null;

    public function render()
    {
        return view('livewire.insider-transactions.form', [
            'content' => $this->content
        ]);
    }

    public function load()
    {
        $this->content =  $this->sourceLink ? (file_get_contents($this->sourceLink) ?? '') : '';
    }

    public static function attributes(): array
    {
        return [
            'size' => '6xl',
        ];
    }
}
