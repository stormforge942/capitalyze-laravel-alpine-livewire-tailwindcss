<div x-data="{ open: false, html: '' }" @showinfomodal.window="() => {open = true; html = $event.detail.html}">
    <template x-if="open">
        <div class="relative z-[100]" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg p-5"
                        @click.away="open = false">
                        <div class="flex justify-between items-center">
                            <h3 class="uppercase font-semibold tracking-wide mb-3">Info</h3>

                            <button @click="open = false">
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
    </template>
</div>
