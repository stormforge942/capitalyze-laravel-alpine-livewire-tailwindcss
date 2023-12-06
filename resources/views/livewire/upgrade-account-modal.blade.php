<div class="flex flex-col h-full">
    @if ($submitted)
        <div class="px-8 pt-6 pb-8 space-y-6">
            <div class="flex justify-center">
                <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M40.0013 73.3334C21.5918 73.3334 6.66797 58.4094 6.66797 40.0001C6.66797 21.5906 21.5918 6.66675 40.0013 6.66675C58.4106 6.66675 73.3346 21.5906 73.3346 40.0001C73.3346 58.4094 58.4106 73.3334 40.0013 73.3334ZM36.6766 53.3334L60.247 29.7632L55.533 25.0491L36.6766 43.9054L27.2487 34.4771L22.5346 39.1914L36.6766 53.3334Z"
                        fill="#52D3A2" />
                </svg>
            </div>

            <div class="text-center">
                <p class="text-lg font-medium">Thank you for your interest</p>
                <p class="mt-2 text-gray-medium2 text-md">We will contact you with more information soon</p>
            </div>

            <button
                class="bg-green-dark hover:bg-green-light2 w-full px-4 py-3 font-semibold rounded transition" wire:click="$emit('modal.close')">
                Continue
            </button>
        </div>
    @else
        <div class="px-8 py-4 flex items-center justify-between">
            <div></div>
            <div class="font-medium text-lg">Account Upgrade</div>
            <button wire:click="$emit('modal.close')">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M6.4 19L5 17.6L10.6 12L5 6.4L6.4 5L12 10.6L17.6 5L19 6.4L13.4 12L19 17.6L17.6 19L12 13.4L6.4 19Z"
                        fill="#C22929" />
                </svg>
            </button>
        </div>

        <div class="px-8 pt-6 pb-8 space-y-6" x-data="{
            content: $wire.entangle('content').defer,
            error: {{ $errors->has('content') ? '' : 'false' }},
            submit() {
                this.error = null;
        
                if (this.content.trim().length < 5) {
                    this.error = 'Please enter at least 5 characters.';
                    return;
                }
        
                $wire.submit();
            }
        }">
            <div class="flex justify-center">
                <svg class="h-24 w-24" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M93.8623 51.2532C105.437 19.0366 67.0411 2.49999 49.83 0.580642C12.6159 -3.56738 7.59634 14.7617 1.24474 47.4779C-6.40127 86.8802 22.5798 90.5523 49.83 94.5338C97.896 101.577 82.604 82.6132 93.8623 51.2532Z"
                        fill="#DCF6EC" />
                    <path
                        d="M20.865 69L21.6075 70.365L22.9725 71.1075L21.6075 71.8575L20.865 73.2225L20.115 71.8575L18.75 71.1075L20.115 70.365L20.865 69Z"
                        fill="#52D3A2" />
                    <path
                        d="M32.0625 13.5L33.0525 15.3225L34.875 16.3125L33.0525 17.31L32.0625 19.125L31.065 17.31L29.25 16.3125L31.065 15.3225L32.0625 13.5Z"
                        fill="#121A0F" />
                    <path
                        d="M78.975 29.25L79.5825 30.36L80.7 30.975L79.5825 31.5825L78.975 32.6925L78.3675 31.5825L77.25 30.975L78.3675 30.36L78.975 29.25Z"
                        fill="#52D3A2" />
                    <g clip-path="url(#clip0_5606_64126)">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M47.875 28.5002C37.1745 28.5002 28.5 37.1747 28.5 47.8752C28.5 58.5758 37.1745 67.2502 47.875 67.2502C58.5755 67.2502 67.25 58.5758 67.25 47.8752C67.25 37.1747 58.5755 28.5002 47.875 28.5002ZM27 47.8752C27 36.3463 36.3461 27.0002 47.875 27.0002C59.4039 27.0002 68.75 36.3463 68.75 47.8752C68.75 59.4042 59.4039 68.7502 47.875 68.7502C36.3461 68.7502 27 59.4042 27 47.8752Z"
                            fill="#121A0F" />
                        <path
                            d="M49.5394 57.75H47.0981V45.1238H49.5394V57.75ZM47.0456 41.6063C46.7131 41.2563 46.5469 40.8363 46.5469 40.3463C46.5469 39.8563 46.7131 39.4363 47.0456 39.0863C47.3956 38.7363 47.8156 38.5613 48.3056 38.5613C48.7956 38.5613 49.2156 38.7363 49.5656 39.0863C49.9156 39.4188 50.0906 39.8388 50.0906 40.3463C50.0906 40.8363 49.9156 41.2563 49.5656 41.6063C49.2156 41.9388 48.7956 42.105 48.3056 42.105C47.8156 42.105 47.3956 41.9388 47.0456 41.6063Z"
                            fill="#121A0F" />
                    </g>
                    <defs>
                        <clipPath id="clip0_5606_64126">
                            <rect width="42" height="42" fill="white" transform="translate(27 27)" />
                        </clipPath>
                    </defs>
                </svg>
            </div>

            <div class="text-center">
                <p class="text-lg font-medium">Upgrade your account to download</p>
                <p class="mt-2 text-md text-gray-medium2">
                    If you're interested in upgrading your account, please send us a
                    message and we'll be in touch!
                </p>
            </div>

            <div>
                <div class="px-4 py-2 border rounded" :class="error ? 'border-red' : 'border-[#D4DDD7]'">
                    <span class="inline-block text-gray-medium2 transition-[font-size]"
                        :class="content.length ? 'text-sm' : 'text-base'">
                        What would you like to tell us?
                    </span>
                    <textarea rows="5" class="resize-none w-full border-none focus:outline-0 focus:ring-0" x-model="content"></textarea>
                </div>

                <p class="mt-2.5 text-red text-sm inline-block" x-show="error" x-cloak x-text="error"></p>
            </div>

            <button
                class="bg-green-dark hover:bg-green-light2 w-full px-4 py-3 font-semibold rounded disabled:bg-[#D1D3D5] disabled:pointer-events-none transition"
                @click="submit" wire:loading.attr="disabled">
                Submit
            </button>
        </div>
    @endif
</div>
