<div class="nav-group">
    <x-dropdown placement="left-end" :shadow="true" class="nav-group-head">
        <x-slot name="trigger">
            <div class="flex items-center gap-2 text-blue" @click="if(!collapsed) { $event.stopPropagation() }">
                {{ $icon ?? '' }}
                <span class="font-semibold" x-show="!collapsed">{{ $name }}</span>
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
                                class="w-full flex items-center justify-between p-2 text-dark-light @if ($item['active'] ?? false) bg-green-light font-medium @else hover:bg-[#828c851a] @endif rounded group">
                                {{ $item['title'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </x-dropdown>

    <ul class="mt-4 space-y-2" x-show="!collapsed">
        @foreach ($items as $item)
            <li>
                <a href="{{ $item['url'] ?? '#' }}"
                    class="w-full flex items-center justify-between px-4 py-3 text-dark-light @if ($item['active'] ?? false) bg-green-light font-medium @else hover:bg-[#828c851a] @endif rounded group">
                    {{ $item['title'] }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
