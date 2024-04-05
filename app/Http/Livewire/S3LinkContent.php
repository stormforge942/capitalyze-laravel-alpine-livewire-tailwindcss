<?php

namespace App\Http\Livewire;

use WireElements\Pro\Components\SlideOver\SlideOver;

class S3LinkContent extends SlideOver
{
    public string $sourceLink;
    private string $content = '';
    
    public function render()
    {
        return view('livewire.s3-link-content', [
            'content' => $this->content
        ]);
    }

    public function load() {
        $this->content = file_get_contents($this->sourceLink) ?? '';
    }

    public static function attributes(): array
    {
        return [
            'size' => '6xl',
        ];
    }
}
