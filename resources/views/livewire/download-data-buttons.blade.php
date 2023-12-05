<div class="font-medium rounded-lg overflow-hidden text-sm flex items-center" x-data="{
    download(type) {
        if($wire.requireProAccount) {
            Livewire.emit('modal.open', 'upgrade-account-modal');
            return;
        }

        this.$dispatch('download', type);
    }
}">
    <button class="pl-6 pr-2 py-4 flex items-center gap-1 bg-[#EDEDED] hover:bg-gray-medium" @click.prevent="download('pdf')">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path
                d="M8.66634 6.66667H11.9997L7.99967 10.6667L3.99967 6.66667H7.33301V2H8.66634V6.66667ZM2.66634 12.6667H13.333V8H14.6663V13.3333C14.6663 13.7015 14.3679 14 13.9997 14H1.99967C1.63149 14 1.33301 13.7015 1.33301 13.3333V8H2.66634V12.6667Z"
                fill="#121A0F" />
        </svg>

        <span>Download PDF</span>
    </button>
    <button class="px-2 py-4 flex items-center gap-1 bg-[#EDEDED] hover:bg-gray-medium" @click.prevent="download('excel')">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path
                d="M8.66634 6.66667H11.9997L7.99967 10.6667L3.99967 6.66667H7.33301V2H8.66634V6.66667ZM2.66634 12.6667H13.333V8H14.6663V13.3333C14.6663 13.7015 14.3679 14 13.9997 14H1.99967C1.63149 14 1.33301 13.7015 1.33301 13.3333V8H2.66634V12.6667Z"
                fill="#121A0F" />
        </svg>
        <span>Download Excel</span>
    </button>
    <button class="pr-6 pl-2 py-4 flex items-center gap-1 bg-[#EDEDED] hover:bg-gray-medium" @click.prevent="download('csv')">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path
                d="M8.66634 6.66667H11.9997L7.99967 10.6667L3.99967 6.66667H7.33301V2H8.66634V6.66667ZM2.66634 12.6667H13.333V8H14.6663V13.3333C14.6663 13.7015 14.3679 14 13.9997 14H1.99967C1.63149 14 1.33301 13.7015 1.33301 13.3333V8H2.66634V12.6667Z"
                fill="#121A0F" />
        </svg>
        <span>Download CSV</span>
    </button>
</div>
