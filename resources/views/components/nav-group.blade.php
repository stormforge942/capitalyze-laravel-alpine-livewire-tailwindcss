@if (count($items))
    <div class="nav-group" x-data="{ expanded: {{ $collapsed ? 'false' : 'true' }} }" x-cloak>
        <x-dropdown placement="left-end" :shadow="true" class="nav-group-head" :full-width-trigger="true">
            <x-slot name="trigger">
                <div class="flex gap-3 items-center justify-between"
                    @click="(e) => {
                if(!collapsed) {
                    e.stopPropagation();
                    expanded = !expanded;
                };
            }">
                    <div class="flex flex-1 items-center gap-2 text-blue">
                        {{ $icon ?? '' }}
                        <span class="font-semibold whitespace-nowrap" x-show="!collapsed">{{ $name }}</span>
                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform" viewBox="0 0 16 16"
                        fill="none" x-show="!collapsed" :class="expanded ? 'rotate-90' : ''">
                        <path
                            d="M8.78419 8.00047L5.48437 4.70062L6.42718 3.75781L10.6699 8.00047L6.42718 12.2431L5.48437 11.3003L8.78419 8.00047Z"
                            fill="#3561E7" />
                    </svg>
                </div>
            </x-slot>

            <div class="py-4 space-y-2" style="width: 13rem">
                <div class="px-4 py-2 text-sm text-blue font-semibold">
                    {{ $name }}
                </div>

                <div class="overflow-y-auto dropdown-scroll" style="max-height: 21rem">
                    <ul class="px-4 space-y-2 text-sm+">
                        @foreach ($items as $item)
                            <li>
                                <a href="{{ $item['url'] ?? '#' }}"
                                    class="w-full flex items-center justify-between p-2 @if ($item['active'] ?? false) bg-green-light text-dark font-semibold @else text-dark-light2 hover:bg-[#828c851a] @endif rounded group">
                                    {{ $item['title'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </x-dropdown>

        <ul class="mt-4 space-y-2" x-show="collapsed ? false : (expanded ? true : false)">
            @foreach ($items as $item)
                <li class="2xl:pl-4">
                    <a href="{{ $item['url'] ?? '#' }}"
                        class="whitespace-nowrap w-full flex items-center justify-between px-4 2xl:pl-6 py-2 @if ($item['active'] ?? false) bg-green-light text-dark font-semibold @else text-dark-light2 hover:bg-[#828c851a] @endif rounded group">
                        {{ $item['title'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endif
