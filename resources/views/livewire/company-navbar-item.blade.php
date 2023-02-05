@if ($active)
    <a href="{{ $href }}"
        class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-900 bg-gray-100 rounded-md "
        aria-current="page">{{ $name }}</a>
@else
    <a href="{{ $href }}"
        class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-900 rounded-md hover:bg-gray-50 hover:text-gray-900">{{ $name }}</a>
@endif
