<div x-data="{
    scrolling: false,
    activeTab: @if (count($sidebarLinks)) '{{ $sidebarLinks[0]['link'] }}' @else null @endif,
    openSource() {
        let sourceLink = `{{ $menuLinks['s3_url'] ?? '' }}`

        if (sourceLink) {
            window.livewire.emit('slide-over.open', 'business-information-source-slide', { sourceLink }, {
                force: true
            });
        }
    },
    toggle(tab, clear = true) {
        if (this.activeTab === tab && clear) {
            this.activeTab = null
            return
        }

        this.activeTab = tab
    },
    setActive(tab) {
        this.scrolling = true
        window.smoothScroll(tab.replace('#', ''))
        this.activeTab = tab
        setTimeout(() => {
            this.scrolling = false
        }, 1000)
    },
    init() {
        const links = [...$refs.contentArea.querySelectorAll('.anchor')].map((el) => '#' + el.getAttribute('id'))

        let callback = (entries, observer) => {
            if (window.innerWidth <= 1024 || this.scrolling) {
                return;
            }

            for (let entry of entries) {
                if (entry.isIntersecting) {
                    this.activeTab = '#' + entry.target.getAttribute('id')
                    break
                }
            }
        }

        let observer = new IntersectionObserver(callback, {
            threshold: 1
        });

        links.forEach((link) => {
            const element = $refs.contentArea.querySelector(link)

            if (element) {
                observer.observe(element)
            }
        })
    },
}">
    <x-card class="block lg:hidden max-w-[612px] w-full">
        <div class="flex items-center justify-between gap-4">
            <h3 class="font-semibold text-lg">Business</h3>
            @if (($menuLinks['s3_url'] ?? false) && ($menuLinks['acceptance_time'] ?? false))
                <a href="{{ $menuLinks['s3_url'] ?? '#' }}" @click.prevent="openSource" class="underline text-xs">
                    Source: FY {{ date('Y', strtotime($menuLinks['acceptance_time'])) }} 10-K
                </a>
            @else
                <span></span>
            @endif
        </div>

        <div class="mt-4 space-y-6">
            @foreach ($sidebarLinks as $item)
                <div>
                    <a href="#" class="flex gapx-5 items-center justify-between"
                        @click.prevent="toggle('{{ $item['link'] }}')">
                        <span class="text-blue">
                            {{ $item['anchorText'] }}
                        </span>

                        <svg :class="activeTab === '{{ $item['link'] }}' ? 'rotate-90' : ''" width="16"
                            height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M8.78419 8.00047L5.48438 4.70062L6.42718 3.75781L10.6699 8.00047L6.42718 12.2431L5.48438 11.3003L8.78419 8.00047Z"
                                fill="#3561E7" />
                        </svg>
                    </a>

                    <div class="mt-3 bussiness-information-content" x-show="activeTab == '{{ $item['link'] }}'" x-cloak>
                        @php
                            $matches = [];
                            preg_match_all('/' . $item['startRegex'] . '(.*)' . $item['endRegex'] . '/i', $businessContent, $matches);
                            $text = $matches[1];
                        @endphp
                        {!! $text[0] ?? '' !!}
                    </div>
                </div>
            @endforeach
        </div>
    </x-card>

    <div class="hidden lg:flex gap-6">
        <div class="lg:max-w-[723px] xl:max-w-[800px] flex-1">
            <x-card>
                <div class="bussiness-information-content" x-ref="contentArea">
                    {!! $businessContent !!}
                </div>
            </x-card>
        </div>

        @if (count($sidebarLinks))
            <div class="max-w-[300px] w-full">
                <x-card class="sticky top-2">
                    <div class="space-y-2 text-blue">
                        @foreach ($sidebarLinks as $item)
                            <button class="w-full py-2 px-4 text-left rounded"
                                :class="activeTab === '{{ $item['link'] }}' ? 'bg-green bg-opacity-20 text-dark' :
                                    'hover:bg-gray-100'"
                                @click="setActive('{{ $item['link'] }}')">
                                {{ $item['anchorText'] }}
                            </button>
                        @endforeach
                    </div>
                    @if (($menuLinks['s3_url'] ?? false) && ($menuLinks['acceptance_time'] ?? false))
                        <div class="mt-3.5 px-4 flex justify-end">
                            <a href="{{ $menuLinks['s3_url'] }}" @click.prevent="openSource" class="underline text-xs">
                                Source: FY {{ date('Y', strtotime($menuLinks['acceptance_time'])) }} 10-K
                            </a>
                        </div>
                    @endif
                </x-card>
            </div>
        @endif
    </div>
</div>
