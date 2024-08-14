<?php
namespace App\Http\Livewire;

use WireElements\Pro\Components\SlideOver\SlideOver;

class EarningPresentationContent extends SlideOver
{
    public ?string $sourceLink = null;
    
    public function render()
    {
        return view('livewire.earning-presentation-content');
    }

    public static function attributes(): array
    {
        return [
            'size' => '6xl',
        ];
    }
}
