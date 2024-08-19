<?php
namespace App\Http\Livewire;

use WireElements\Pro\Components\SlideOver\SlideOver;

class EarningPresentationContent extends SlideOver
{
    public ?string $sourceLink = null;
    public $pdfDataUrl = null;

    public function render()
    {
        return view('livewire.earning-presentation-content', [
            'pdfDataUrl' => $this->pdfDataUrl,
        ]);
    }

    public function load()
    {
        if ($this->sourceLink) {
            // Fetch the PDF content
            $pdfContent = file_get_contents($this->sourceLink);
            
            // Convert binary PDF content to base64
            $base64 = base64_encode($pdfContent);
            
            // Create a data URL
            $this->pdfDataUrl = 'data:application/pdf;base64,' . $base64;
        }
    }
    public static function attributes(): array
    {
        return [
            'size' => '6xl',
        ];
    }
}
