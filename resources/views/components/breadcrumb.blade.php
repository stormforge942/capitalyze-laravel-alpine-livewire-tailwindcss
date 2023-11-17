<div {{ $attributes->merge(['class' => 'flex items-center gap-2 pl-2 py-1 text-sm font-medium text-dark-light2']) }}>
    @foreach ($items as $idx => $item)
        @if ($item['href'] ?? false)
            <a href="{{ $item['href'] }}" class="hover:underline" x-ref="breadItem{{ $idx }}">
                {{ $item['text'] }}
            </a>
        @else
            <span x-ref="breadItem{{ $idx }}">{{ $item['text'] }}</span>
        @endif

        @if (!$loop->last)
            <span class="text-dark-lighter w-4 text-center">/</span>
        @endif
    @endforeach

    @if ($chevron)
        <svg class="-ml-1 shrink-0" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
            fill="none">
            <path d="M10.2536 8L6.25365 12L5.32031 11.0667L8.38698 8L5.32031 4.93333L6.25365 4L10.2536 8Z"
                fill="#464E49" />
        </svg>
    @endif

    {{ $slot ?? '' }}
</div>
