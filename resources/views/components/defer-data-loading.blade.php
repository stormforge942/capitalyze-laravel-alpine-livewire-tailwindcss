@if ($useAlpine)
    <div x-data="{
        result: null,
        state: 'loading',
        load() {
            this.state = 'loading';
            $wire.{{ $onInit }}().then(res => {
                    this.result = res;
                })
                .catch(err => {
                    this.state = 'error';
                })
                .finally(() => {
                    this.state = 'ready';
                    $dispatch('ready')
                });
        }
    }" x-init="load" @if($attributes->has('@ready')) @ready="{{ $attributes->get('@ready') }}" @endif>
        <template x-if="state === 'loading'">
            <div {{ $attributes->merge(['class' => 'grid place-items-center']) }}>
                @if (!isset($loading))
                    <span class="mx-auto simple-loader !text-blue"></span>
                @else
                    {{ $loading }}
                @endif
            </div>
        </template>
        <template x-if="state === 'ready'">
            <div>
                {{ $slot }}
            </div>
        </template>
        <template x-if="state === 'error'">
            <p class="text-red-500 text-center">
                Something went wrong while loading the data.
            </p>
        </template>
    </div>
@else
    <div wire:init="{{ $onInit }}" wire:loading.remove>
        {{ $slot }}
    </div>

    <div wire:loading.grid {{ $attributes->merge(['class' => 'place-items-center']) }}>
        @if (!isset($loading))
            <span class="mx-auto simple-loader !text-blue"></span>
        @else
            {{ $loading }}
        @endif
    </div>
@endif
