<div x-data="{
    data: @entangle('data'),
    activeTab: @entangle('activeTab').defer,
    activeLink: @entangle('activeLink').defer,
    onLinkClick(data) {
        this.$wire.setContent(data.link)
            .then(
                this.setActiveLink(data.id)
            );
    },
    setActiveLink(data) {
        this.activeLink = data;
    },
    isActiveLink(data) {
        return data === this.activeLink
    },
    onTabChange(e) {
        window.updateQueryParam('{{ $activeTab['key'] }}', '')
        $wire.setTabName(e.detail)
        $wire.refresh()
    }
}" class="flex flex-col h-full p-5" wire:init="loadData">
    <div class="mb-5 flex gap-5 items-start justify-between">
        <div class="font-medium uppercase">{{ $row['description'] }}</div>

        <button wire:click="$emit('modal.close')">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z"
                    fill="#C22929" />
            </svg>
        </button>
    </div>

    <div>
        @if($data)
            <div wire:ignore>
                <x-primary-tabs :tabs="$tabs" :active="$activeTab['key']" :queryLabel="'presentationTab'"  @tab-changed="onTabChange" :wire:key="$activeTab['key']"></x-primary-tabs>
            </div>
        @endif
        
        <div class="mb-4">
            <template x-if="data">
                <template x-for="(item, index) in data[activeTab.title]" :key="index">
                    <p x-text="item.name" :class="isActiveLink(item.id) ? 'text-green' : ''" class="cursor-pointer py-2" @click="onLinkClick(item)"></p>
                </template>
            </template>
        </div>
    </div>

    <div class="py-24 place-items-center" wire:loading.grid>
        <span class="mx-auto simple-loader text-green"></span>
    </div>

    <div wire:loading.remove>
        @if ($content)
            <div class="show-scrollbar" style="max-height: 80vh; overflow-y: scroll;">
                {!! $content !!}
            </div>
        @else
            <p class="text-gray-500 text-center py-24">No result found</p>
        @endif
    </div>
</div>
