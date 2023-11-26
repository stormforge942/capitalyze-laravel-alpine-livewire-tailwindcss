<div {{ $attributes->merge(['class' => 'bg-white p-4 md:p-6 rounded-lg']) }}>
    @if (isset($head))
        <div class="mb-4">
            {{ $head }}
        </div>
    @elseif(isset($title) || isset($topRight))
        <div class="mb-4 flex items-center justify-between gap-x-5">
            <h3 class="text-blue text-sm font-semibold inline-block">{{ $title ?? '' }}</h3>

            @if (isset($topRight))
                <div>
                    {{ $topRight }}
                </div>
            @endif
        </div>
    @endif

    <div>
        {{ $slot ?? '' }}
    </div>
</div>
