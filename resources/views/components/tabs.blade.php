@props(['tabs' => [], 'active' => 0])

<div x-data="{active: {{ $active }}}" {{ $attributes }}>
    <div>
        <div class="border p-1 rounded-lg inline-flex items-center gap-1 text-sm font-semibold">
            @foreach ($tabs as $idx => $tab)
            <button class="rounded px-6 py-2 transition"
                :class="active == {{ $idx }} ? 'bg-blue text-white' : 'hover:bg-gray-light'"
                @click="active = {{ $idx }}">
                {{ $tab }}</button>
            @endforeach
        </div>
    </div>

    <div class="mt-4 text-sm">
        {{ $slot }}
    </div>
</div>