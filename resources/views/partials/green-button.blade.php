<button type="{{ $type ?? 'button' }}" class="block w-full px-4 py-3 bg-green-dark hover:bg-green-light2 font-semibold rounded disabled:bg-[#D1D3D5] disabled:pointer-events-none transition" @foreach(($attrs ?? []) as $aKey => $aVal) {{ $aKey }}="{{ $aVal }}" @endforeach>
    {{ $text }}
</button>