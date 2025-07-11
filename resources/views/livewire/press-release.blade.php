<div>
    <div>
        <livewire:company-navbar :company="$company ?? ['ticker' => 'aapl']" />
        <!-- Page Content Begin -->
        <main>
            <div class="p-4 sm:ml-64 pl-0">
                
                <div class="py-2">
                    <div class="mx-auto flex flex-col md:flex-row justify-center">
                        <div class="mx-auto px-4 sm:px-6 lg:px-8 bg-white py-4 shadow md:mx-8 rounded md:w-12/14 2xl:w-2/3 w-full">
                            <div class="sm:flex sm:items-center">
                                <div class="sm:flex-auto text-center">
                                    <h1 class="text-xl font-bold leading-10 text-gray-900">Press Release</h1>
                                </div>
                            </div>
                            <div wire:loading.flex class="justify-center items-center">
                                    <div class="grid place-content-center h-full" role="status">
                                    <svg aria-hidden="true" class="w-12 h-12 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                    </svg>
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                            <div class="overflow-x-scroll">
                                <livewire:press-release-table />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <div class="relative z-[100] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="modal">
            <!--
                Background backdrop, show/hide based on modal state.

                Entering: "ease-out duration-300"
                From: "opacity-0"
                To: "opacity-100"
                Leaving: "ease-in duration-200"
                From: "opacity-100"
                To: "opacity-0"
            -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <!--
                    Modal panel, show/hide based on modal state.

                    Entering: "ease-out duration-300"
                    From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    To: "opacity-100 translate-y-0 sm:scale-100"
                    Leaving: "ease-in duration-200"
                    From: "opacity-100 translate-y-0 sm:scale-100"
                    To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                -->
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-2">
                            <p class="text-sm text-gray-500" id="modal-text"></p>
                        </div>
                    </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button onclick="hideModal()" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Close</button>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <!-- Page Content End -->
    </div>
</div>


@push('scripts')
<script>
    function showModal(e) {
        var value = e.dataset.value;
        var elem = document.getElementById('modal');

        elem.classList.add('block');
        elem.querySelector('#modal-text').innerHTML = value;
        elem.classList.remove('hidden');
    }

    function hideModal() {
        var elem = document.getElementById('modal');

        elem.classList.remove('block');
        elem.querySelector('#modal-text').innerHTML = '';
        elem.classList.add('hidden');
    }
</script>
@endpush