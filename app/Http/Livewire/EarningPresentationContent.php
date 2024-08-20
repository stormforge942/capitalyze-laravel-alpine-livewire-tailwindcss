<?php

namespace App\Http\Livewire;

use WireElements\Pro\Components\SlideOver\SlideOver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class EarningPresentationContent extends SlideOver
{
    public ?string $sourceLink = null;

    public function render()
    {
        return view('livewire.earning-presentation-content');
    }

    public function load(Request $request)
    {
        $sourceLink = $request->input('sourceLink');
        
        if ($sourceLink) {
            $response = Http::withOptions(['stream' => true])->get($sourceLink);

            if ($response->ok()) {
                return Response::stream(
                    function () use ($response) {
                        echo $response->body();
                    },
                    $response->status(),
                    [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'inline; filename="document.pdf"',
                    ]
                );
            }
        }

        abort(404, 'File not found');
    }

    public static function attributes(): array
    {
        return [
            'size' => '6xl',
        ];
    }
}
