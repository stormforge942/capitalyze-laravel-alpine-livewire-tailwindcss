<div
    class="flex items-center border-b border-[#828C85] focus-within:border-dark-light2 pl-1 md:pl-4 py-2.5 gap-x-1 lg:gap-x-4 text-dark-light2">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
            d="M15.8645 14.3208H15.0515L14.7633 14.0429C15.7719 12.8696 16.3791 11.3465 16.3791 9.68954C16.3791 5.99485 13.3842 3 9.68954 3C5.99485 3 3 5.99485 3 9.68954C3 13.3842 5.99485 16.3791 9.68954 16.3791C11.3465 16.3791 12.8696 15.7719 14.0429 14.7633L14.3208 15.0515V15.8645L19.4666 21L21 19.4666L15.8645 14.3208ZM9.68954 14.3208C7.12693 14.3208 5.05832 12.2521 5.05832 9.68954C5.05832 7.12693 7.12693 5.05832 9.68954 5.05832C12.2521 5.05832 14.3208 7.12693 14.3208 9.68954C14.3208 12.2521 12.2521 14.3208 9.68954 14.3208Z"
            fill="#464E49" />
    </svg>

    <input type="search"
        class="h-6 w-[9rem] sm:w-auto xl:w-[21.5rem] appearance-none bg-transparent border-0 ring-0 focus:outline-0 focus-within:ring-0 focus-within:outline-0"
        placeholder="Search funds..."
        @if ($useAlpine ?? false) @input.debounce.800ms="Livewire.emit('{{ $event ?? 'runSearch' }}', $event.target.value)" @else wire:model.debounce.800ms="search" @endif wire:ignore>
</div>
