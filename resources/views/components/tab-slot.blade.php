<template x-teleport="#{{ $id }} .tab-slot {{ $tab ? ".slot-$tab" : '' }}" {{ $attributes }}>
    {{ $slot }}
</template>
