<template x-teleport="#{{ $id }} .tab-slot">
    <div {{ $attributes }} @if($tab) x-show="active === '{{ $tab }}'" x-cloak @endif>
        {{ $slot }}
    </div>
</template>
