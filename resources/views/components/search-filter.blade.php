<div x-data="{
        paddingY: 'py-{{ $py }}',
        fontSizes: {
            'sm+': 'text-sm+ placeholder:text-sm+',
            'base': 'text-base placeholder:text-base'
        }
    }"
    class="bg-white flex items-center pl-4 pr-2 border border-[#D4DDD7] rounded-lg"
    x-bind:class="paddingY"
>
    <svg class="h-6 w-6 shrink-0" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
            d="M15.8645 14.3208H15.0515L14.7633 14.0429C15.7719 12.8696 16.3791 11.3465 16.3791 9.68954C16.3791 5.99485 13.3842 3 9.68954 3C5.99485 3 3 5.99485 3 9.68954C3 13.3842 5.99485 16.3791 9.68954 16.3791C11.3465 16.3791 12.8696 15.7719 14.0429 14.7633L14.3208 15.0515V15.8645L19.4666 21L21 19.4666L15.8645 14.3208ZM9.68954 14.3208C7.12693 14.3208 5.05832 12.2521 5.05832 9.68954C5.05832 7.12693 7.12693 5.05832 9.68954 5.05832C12.2521 5.05832 14.3208 7.12693 14.3208 9.68954C14.3208 12.2521 12.2521 14.3208 9.68954 14.3208Z"
            fill="#828C85" />
    </svg>

    <input type="search" placeholder="{{ $placeholder }}"
        x-bind:class="fontSizes['{{ $fontSize }}']"
        class="placeholder:text-gray-medium2 border-none flex-1 focus:outline-none focus:ring-0 h-[30px] min-w-0 search-x-button placeholder:font-medium"
        {{ $attributes }}>
</div>
