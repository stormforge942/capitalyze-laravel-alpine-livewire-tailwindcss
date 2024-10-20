<?php

$metricsSelector = [
    'options' => App\Services\ScreenerTableBuilderService::viewOptions(),
    'dates' => App\Services\ScreenerTableBuilderService::dataDateRange(),
];

?>

<div class="bg-white rounded-t p-2 border-b-2 border-gray-light">
    <div class="flex items-center justify-between gap-x-5" x-data="{
        active: $wire.entangle('active'),
        views: $wire.entangle('views', true),
        activeView: null,
        init() {
            this.activeView = this.views.find(view => view.id === this.active);

            this.$nextTick(() => {
                this.$el.querySelector('.active-view').scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest',
                    inline: 'center',
                });
            });
        
            this.$watch('active', value => {
                this.activeView = this.views.find(view => view.id === value);
            });
        },
    }" style="max-width: 100%;" wire:ignore>
        <div class="flex items-center gap-x-2 overflow-hidden">
            <div class="flex items-center gap-x-2 overflow-x-auto" style="max-width: 80%">
                <template x-for="view in views" :key="view.id">
                    <button class="px-4 py-2 rounded text-sm font-medium whitespace-nowrap"
                        :class="active === view.id ? 'bg-green-light4 active-view' : 'hover:bg-gray-light'"
                        x-text="view.name" @click="active = view.id">
                    </button>
                </template>
            </div>

            <x-dropdown placement="bottom-end" :shadow="true">
                <x-slot name="trigger">
                    <div
                        class="px-4 py-2 rounded text-sm font-medium bg-green-light4 border border-dark flex items-center gap-x-2 whitespace-nowrap">
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

        <template x-if="active != 'default'">
            <div @update-view="$wire.updateView($event.detail)">
                <x-dropdown placement="bottom-end" :shadow="true">
                    <x-slot name="trigger">
                        <div class="px-4 py-2 rounded text-sm font-semibold flex items-center gap-x-1">
                            <span>Settings</span>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M6.6347 1.47406C7.52376 1.28795 8.4525 1.28208 9.36196 1.47222C9.47996 2.24526 9.93523 2.9596 10.6652 3.38101C11.395 3.80241 12.2414 3.83955 12.9698 3.55519C13.5892 4.24778 14.0485 5.05501 14.3318 5.918C13.7222 6.40671 13.3318 7.15766 13.3318 7.99979C13.3318 8.84246 13.7226 9.59379 14.3329 10.0825C14.192 10.5094 14.0056 10.9285 13.772 11.3331C13.5383 11.7379 13.2686 12.1088 12.9693 12.4443C12.241 12.1601 11.3949 12.1973 10.6652 12.6186C9.93583 13.0397 9.4807 13.7533 9.36223 14.5256C8.47323 14.7117 7.5445 14.7175 6.63498 14.5274C6.51702 13.7544 6.0617 13.04 5.33181 12.6186C4.60192 12.1972 3.75562 12.1601 3.02718 12.4445C2.40774 11.7519 1.94847 10.9446 1.66512 10.0816C2.27478 9.59292 2.66515 8.84192 2.66515 7.99979C2.66515 7.15719 2.27432 6.40584 1.66406 5.91715C1.80492 5.4902 1.99132 5.07118 2.22498 4.66648C2.45864 4.26177 2.72832 3.89083 3.02764 3.55537C3.75598 3.83953 4.60208 3.80232 5.33181 3.38101C6.06112 2.95994 6.5163 2.24639 6.6347 1.47406ZM7.9985 9.99979C9.10303 9.99979 9.9985 9.10439 9.9985 7.99979C9.9985 6.89526 9.10303 5.99981 7.9985 5.99981C6.8939 5.99981 5.99848 6.89526 5.99848 7.99979C5.99848 9.10439 6.8939 9.99979 7.9985 9.99979Z"
                                    fill="#121A0F" />
                            </svg>
                        </div>
                    </x-slot>

                    <div>
                        @include('livewire.screener.metrics-selector')
                    </div>
                </x-dropdown>
            </div>
        </template>
    </div>
</div>
