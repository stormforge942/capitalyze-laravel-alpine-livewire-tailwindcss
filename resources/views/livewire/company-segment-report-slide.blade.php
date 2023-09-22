<x-wire-elements-pro::tailwind.slide-over :content-padding="false">
    <x-slot name="title">
        Bug report
    </x-slot>
    <div class="px-4 sm:px-6 h-full flex-col">
        <div class="flex flex-col">
            <div class="mb-4">
                <label class="label" for="amount">
                    Date:
                </label>
                <div class="display-text">
                    {{ $date }}
                </div>
            </div>

            <div class="mb-4">
                <label class="label" for="amount">
                    Correct amount:
                </label>
                <div class="display-text">
                    ${{ number_format($previousAmount) }}
                </div>
            </div>

            <div class="mb-4">
                <label class="label" for="amount">
                    Correct amount
                </label>
                <input wire:model="amount" class="input" id="amount" type="text" placeholder="100000.00">
                @error('amount')
                <span class="validation-error">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="label" for="link">
                    Link to statement
                </label>
                <input wire:model="link" class="input" id="link" type="text" placeholder="https://www.domain.com">
                @error('link')
                <span class="validation-error">{{ $message }}</span> @enderror
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

            <div class="mb-4">
                <label class="label" for="explanations">
                    Explanations
                </label>
                <textarea wire:model="explanations" class="input" id="explanations" type="text" placeholder="..."></textarea>
            </div>
        </div>

        <div class="flex flex-row space-x-2">
            <div wire:click="submit">
                <livewire:button icon="edit" text="Save" class="secondary"/>
            </div>
            <div wire:click="$emit('slide-over.close')">
                <livewire:button text="Cancel" class="cancel" />
            </div>
        </div>
    </div>
</x-wire-elements-pro::tailwind.slide-over>
