<x-wire-elements-pro::tailwind.slide-over>
    <div class="h-full" wire:init="load">
        <div class="place-items-center" wire:loading.grid>
            <span class="mx-auto simple-loader text-blue"></span>
        </div>

        <div class="h-full" wire:loading.remove>
            @if ($content)
                <div class="h-full"
                    @if ($balance) x-data="{
                    init() {
                        const iframe = this.$el.children[0]

                        iframe.onload = () => {
                            window.reportTextHighlighter.highlight(
                                {{ $balance }},
                                {{ round($balance) }},
                                ['table tbody tr td p', 'balance'],
                                iframe.contentDocument
                            )

                            setTimeout(() => {
                                const highlightText = iframe.contentDocument.getElementsByClassName('highlight-text')
                                if (highlightText.length) {
                                    highlightText[0].scrollIntoView({
                                        block: 'start',
                                        behavior: 'smooth',
                                        inline: 'start'
                                    })
                                }
                            }, 100)
                        }
                                            }
                }" @endif>
                    <iframe class="w-full h-full" srcdoc="{!! strip_tags(htmlspecialchars($content)) !!}" frameborder="0"></iframe>
                </div>
            @else
                <div class="text-center text-gray-500">
                    No content found
                </div>
            @endif
        </div>
    </div>
</x-wire-elements-pro::tailwind.slide-over>
