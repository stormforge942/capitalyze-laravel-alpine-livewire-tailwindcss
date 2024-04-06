<x-wire-elements-pro::tailwind.slide-over>
    <div class="h-full" wire:init="load">
        <div class="place-items-center" wire:loading.grid>
            <span class="mx-auto simple-loader text-blue"></span>
        </div>

        <div class="relative h-full" wire:loading.remove>
            @if (!$content)
                <p class="py-5 text-center text-gray-500">
                    No content found
                </p>
            @else
                {!! $content !!}

                @if ($quantity)
                    <script>
                        window.reportTextHighlighter.highlight({{ $quantity }}, '.wep-slide-over table tbody tr td .FormData')
                    </script>
                @endif
            @endif
        </div>
    </div>
</x-wire-elements-pro::tailwind.slide-over>
