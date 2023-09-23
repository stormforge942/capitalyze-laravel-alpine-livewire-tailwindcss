<style>
    [x-cloak] {
        display: none;
    }
</style>

<div x-data="{
    show: false,
    html: 'Hello world',
    close() {
        this.html = '';
        this.show = false;
    },
    open(html) {
        this.html = html;
        this.show = true;
    }
}" @openinfomodal.window="open($event.detail.html)" :data-show="show ? 'true' : 'false'">
    <div class="relative z-[100]" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-show="show" x-cloak>
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg p-5"
                    @click.away="close">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="uppercase font-bold text-lg tracking-wider">Info</h3>

                        <button @click="close">
                            <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12">
                                </path>
                            </svg>
                        </button>
                    </div>
                    <div x-html="html"></div>
                </div>
            </div>
        </div>
    </div>
</div>
