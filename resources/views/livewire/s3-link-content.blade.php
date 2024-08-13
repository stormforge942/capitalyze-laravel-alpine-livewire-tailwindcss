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
                <div class="h-full" x-data="{
                    init() {
                        const iframe = this.$el.children[0]
                
                        iframe.onload = () => {
                            const doc = iframe.contentDocument;
                            if (doc) {
                                @if($summary)
                                const summaryDiv = doc.createElement('div');
                                summaryDiv.innerHTML = `<h2 style='font-size: 1.125rem; font-weight: 600; color: #2d3748;'>Summary</h2><p style='font-size: 0.875rem; color: #6b7280;'>{{ $summary }}</p>`;
                                summaryDiv.style.padding = '1rem';
                                summaryDiv.style.backgroundColor = '#f7fafc';
                                summaryDiv.style.marginBottom = '1rem';
                                doc.body.insertBefore(summaryDiv, doc.body.firstChild);
                                @endif
                
                                const highlightText = doc.getElementsByClassName('highlight-text');
                                if (highlightText.length) {
                                    highlightText[0].scrollIntoView({
                                        block: 'center',
                                        behavior: 'smooth',
                                        inline: 'center'
                                    });
                                }
                            }
                        }
                    }
                }">
                    <iframe class="w-full h-full" srcdoc="{!! strip_tags(htmlspecialchars($content)) !!}" frameborder="0"></iframe>
                </div>
            @endif
        </div>
    </div>
</x-wire-elements-pro::tailwind.slide-over>
