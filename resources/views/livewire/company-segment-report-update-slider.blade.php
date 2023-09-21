<div class="relative z-10" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
    <!-- Background backdrop, show/hide based on slide-over state. -->
    <div class="fixed inset-0"></div>

    <div class="fixed inset-0 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden">
            <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                <div class="pointer-events-auto w-screen max-w-md">
                    <div class="flex h-full flex-col overflow-y-scroll bg-white py-6 shadow-xl">
                        <div class="px-4 sm:px-6">
                            <div class="flex items-start justify-between">
                                <h2 class="text-base font-semibold leading-6 text-gray-900" id="slide-over-title">Panel title</h2>
                                <div class="ml-3 flex h-7 items-center">
                                    <button wire:click="$emitTo('review-page', 'close-slider')" type="button" class="relative rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        <span class="absolute -inset-2.5"></span>
                                        <span class="sr-only">Close panel</span>
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="relative mt-6 flex-1 px-4 sm:px-6">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="link">
                                    Support engineer
                                </label>
                                <input wire:model="supportEngineer" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="link" type="text" placeholder="Name">
                                @error('supportEngineer')
                                <span class="validation-error">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="explanations">
                                    Support engineer comments
                                </label>
                                <textarea wire:model="supportEngineerComments" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="explanations" type="text" placeholder="..."></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="explanations">
                                    Fixed
                                </label>
                                <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                    <input id="ch1" name="ch1" wire:model="fixed" type="checkbox" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"/>
                                    <label for="ch1" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="explanations">
                                    Delete old files
                                </label>
                                <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                    <input id="ch2" name="ch2" wire:model="deleteOldFiles" type="checkbox"  class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"/>
                                    <label for="ch2" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="col-span-full"
                                     x-data="{
                            dropping: false,
                            progress: 0,

                            handleDrop (event) {
                            @this.uploadMultiple(
                                'images',
                                Array.from(event.dataTransfer?.files || event.target.files),
                                (uploadedFilename) => {
                                    this.progress = 0
                                },
                                (e) => {
                                    this.progress = 0
                                },
                                (e) => {
                                    this.progress = e.detail.progress
                                },
                            )
                        }
                }">
                                    <label for="cover-photo" class="block text-sm font-medium leading-6 text-gray-900">
                                        Images
                                    </label>
                                    <div
                                        class="col-span-full" id="dragDivUploaderCompanyReport"
                                        x-on:dragover.prevent="dropping = true"
                                        x-on:dragleave.prevent="dropping = false"
                                        x-on:drop="dropping = false"
                                        x-on:drop.prevent="handleDrop($event)"
                                    >
                                        <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                                            <div class="text-center">
                                                <div class="mt-4 text-sm leading-6 text-blue-700 flex justify-center">
                                                    <label
                                                        for="fileUploadInput"
                                                        class="relative cursor-pointer rounded-md bg-white font-semibold text-blue-700 focus-within:outline-none focus-within:ring-2 focus-within:ring-blue-700 focus-within:ring-offset-2 hover:text-blue-600"
                                                    >
                                                        <span>{{ $fileName ?  : 'Upload a file'}}</span>
                                                        <input wire:model="images" id="fileUploadInput" name="fileUploadInput" type="file" multiple class="sr-only"/>
                                                    </label>
                                                </div>
                                                <p class="text-xs leading-5 text-gray-600">PNG, JPG up to 2MB</p>
                                            </div>
                                        </div>
                                    </div>
                                    @error('images')
                                    <span class="validation-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>


                            <div class="flex flex-row space-x-2">
                                <x-jet-button wire:click="submit">
                                    {{ __('Save') }}
                                </x-jet-button>
                                <button type="button"
                                        class="inline-flex w-full justify-center rounded-md bg-gray-200 px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm hover:bg-gray-300 sm:ml-3 sm:w-auto"
                                        wire:click="$emitTo('review-page', 'close-slider')">
                                    {{ __('CANCEL') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
