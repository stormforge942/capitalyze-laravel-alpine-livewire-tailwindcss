<?php

namespace App\Http\Livewire;

use WireElements\Pro\Components\SlideOver\SlideOver;

class BusinessInformationSourceSlide extends SlideOver
{
    public string $sourceLink;
    private string $content = '';
    
    public function render()
    {
        return view('livewire.business-information-source-slide', [
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
