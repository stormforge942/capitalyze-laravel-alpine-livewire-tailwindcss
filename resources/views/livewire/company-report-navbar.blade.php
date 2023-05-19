<div>
    <div class="px-2 mx-auto max-w-7xl sm:px-4 lg:divide-y lg:divide-gray-200 lg:px-8">
        <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px">
                @foreach(array_keys($navbar) as $value)
                    <li class="inline-block p-4 border-b-2 rounded-t-lg @if($value == $activeIndex)text-blue-600 active border-b-2 border-blue-600 @else cursor-pointer border-transparent hover:text-gray-600 hover:border-gray-300 @endif" wire:click="$emit('tabClicked', '{{$value}}')">{{ Str::title(preg_replace('/\[[^\]]*?\]/', '', $value)) }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="relative px-2 mx-auto max-w-7xl sm:px-4 lg:divide-y lg:divide-gray-200 lg:px-8">
        <div class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
            <div class="flex items-center">
                <button id="scrollLeft" class="absolute left-0 px-2 py-1 text-gray-600 bg-transparent cursor-pointer">
                    <x-heroicon-o-chevron-left class="h-6 w-6"/>
                </button>
                <div class="overflow-x-scroll scrollbar-hide px-1">
                    <ul class="flex flex-nowrap -mb-px">
                        @foreach($navbar[$activeIndex] as $key => $value)
                            <li data-tab-id="{{$value['id']}}" class="inline-block whitespace-nowrap min-w-min p-4 border-b-2 max-h-[50px] overflow-hidden rounded-t-lg @if($value['id'] == $activeSubIndex)text-blue-600 active border-b-2 border-blue-600 @else cursor-pointer border-transparent hover:text-gray-600 hover:border-gray-300 @endif" wire:click="$emit('tabSubClicked', '{{$value['id']}}')">{{ preg_replace('/\[[^\]]*?\]/', '', $value['title']) }}</li>
                        @endforeach
                    </ul>
                </div>

                <button id="scrollRight" class="absolute right-0 px-2 py-1 text-gray-600 bg-transparent cursor-pointer">
                    <x-heroicon-o-chevron-right class="h-6 w-6"/>
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    checkOverflow();
    Livewire.on('contentChanged', function() {
        checkOverflow();
    });
});

Livewire.on('tabSubClicked', function(tabId) {
    // Wait for Livewire to finish updating the DOM
    Livewire.hook('message.processed', (message, component) => {
        var tabElement = document.querySelector(`[data-tab-id="${tabId}"]`);
        if (tabElement) {
            tabElement.scrollIntoView({ behavior: "smooth", block: "nearest", inline: "nearest" });
        }
    });
});

function checkOverflow() {
    var tabContainer = document.querySelector('.overflow-x-scroll');
    var scrollLeftButton = document.getElementById('scrollLeft');
    var scrollRightButton = document.getElementById('scrollRight');

    let overflowed = tabContainer.scrollWidth - 1 > tabContainer.clientWidth;
    scrollLeftButton.style.display = overflowed ? 'block' : 'none';
    scrollRightButton.style.display = overflowed ? 'block' : 'none';
}

// scroll to left
document.getElementById('scrollLeft').addEventListener('click', function() {
    document.querySelector('.overflow-x-scroll').scrollLeft -= 100;
});

// scroll to right
document.getElementById('scrollRight').addEventListener('click', function() {
    document.querySelector('.overflow-x-scroll').scrollLeft += 100;
});
</script>
@endpush