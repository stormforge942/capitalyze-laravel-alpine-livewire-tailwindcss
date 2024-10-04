<?php

$metricsSelector = [
    'options' => App\Services\ScreenerTableBuilderService::viewOptions(),
    'dates' => App\Services\ScreenerTableBuilderService::dataDateRange(),
];

?>

<div class="bg-white rounded-t p-2 border-b-2 border-gray-light">
    <div class="flex items-center gap-x-2 overflow-x-auto" x-data="{
        active: $wire.entangle('active'),
        views: $wire.entangle('views', true),
        onTabClick(e, view) {
            e.preventDefault();
    
            if (this.active !== view.id || view.id === 'default') {
                this.active = view.id;
                e.stopImmediatePropagation();
            }
        },
        updateView(e) {
            $wire.updateView(e.detail)
        }
    }" @update-view="updateView" wire:ignore>
        <template x-for="view in views" :key="view.id">
            <div>
                <x-dropdown placement="bottom-start" :shadow="true">
                    <x-slot name="trigger">
                        <div class="px-4 py-2 rounded text-sm font-medium"
                            :class="active === view.id ? 'bg-green-light4' : 'hover:bg-gray-light'" x-text="view.name"
                            @click="onTabClick($event, view)">
                        </div>
                    </x-slot>
    
                    <div>
                        @include('livewire.screener.metrics-selector')
                    </div>
                </x-dropdown>
            </div>
        </template>

        <x-dropdown placement="bottom-end" :shadow="true">
            <x-slot name="trigger">
                <div
                    class="px-4 py-2 rounded text-sm font-medium bg-green-light4 border border-dark flex items-center gap-x-2">
                    Add View

                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7.99479 14.6693C4.31289 14.6693 1.32812 11.6845 1.32812 8.0026C1.32812 4.3207 4.31289 1.33594 7.99479 1.33594C11.6767 1.33594 14.6615 4.3207 14.6615 8.0026C14.6615 11.6845 11.6767 14.6693 7.99479 14.6693ZM7.32812 7.33594H4.66146V8.66927H7.32812V11.3359H8.66146V8.66927H11.3281V7.33594H8.66146V4.66927H7.32812V7.33594Z"
                            fill="#121A0F" />
                    </svg>
                </div>
            </x-slot>

            <form class="w-[26rem] p-6"
                @submit.prevent="() => {
                    dropdown.hide(); 
                    $wire.addView($el.querySelector('input').value)
                        .then(() => $el.querySelector('input').value = '');
                }">
                <div class="flex justify-between">
                    <span class="font-medium">Create name of view</span>

                    <button @click="dropdown.hide()">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.89497 18.505C6.62161 18.7784 6.17839 18.7784 5.90503 18.505L5.49497 18.095C5.22161 17.8216 5.22161 17.3784 5.49497 17.105L10.6 12L5.49497 6.89497C5.22161 6.62161 5.22161 6.17839 5.49497 5.90503L5.90503 5.49497C6.17839 5.22161 6.62161 5.22161 6.89497 5.49497L12 10.6L17.105 5.49497C17.3784 5.22161 17.8216 5.22161 18.095 5.49497L18.505 5.90503C18.7784 6.17839 18.7784 6.62161 18.505 6.89497L13.4 12L18.505 17.105C18.7784 17.3784 18.7784 17.8216 18.505 18.095L18.095 18.505C17.8216 18.7784 17.3784 18.7784 17.105 18.505L12 13.4L6.89497 18.505Z"
                                fill="#C22929" />
                        </svg>
                    </button>
                </div>

                <input type="text"
                    class="mt-2 w-full px-4 py-3 border border-[#D4DDD7] focus:ring-0 focus:outline-none focus-within:border-green-dark rounded text-sm"
                    placeholder="Name of View" required>

                <button type="submit"
                    class="mt-6 w-full px-4 py-3 font-medium bg-green-dark hover:bg-opacity-80 rounded">
                    Create
                </button>
            </form>
        </x-dropdown>
    </div>
</div>
