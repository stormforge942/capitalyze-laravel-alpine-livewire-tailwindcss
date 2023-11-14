<template x-teleport="#{{ $id }} .tab-slot">
    <div {{ $attributes }} x-show="active === '{{ $tab }}'" x-cloak>
        {{ $slot }}
    </div>
</template>
