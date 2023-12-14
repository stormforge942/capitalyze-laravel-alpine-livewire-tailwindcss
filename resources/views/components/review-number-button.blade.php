@if (auth()->user()->hasNavbar('create.company.segment.report'))
    <button @click.stop="Livewire.emit('slide-over.open', 'company-segment-report-slide', [Number(amount) || 0, date, location.href])"
        class="ml-1 p-1 bg-white hover:bg-black text-dark hover:text-white rounded-full" {{ $attributes }}>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-3 h-3">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
        </svg>
    </button>
@endif
