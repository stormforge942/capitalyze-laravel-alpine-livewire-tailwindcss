@if ($state == 0)
    <div class="flex flex-col h-full">
        <div class="bg-white p-6">
            <div class="block mx-auto text-xl text-center">Update Password</div>
            <form class="mt-4" method="post" @submit.prevent="$wire.confirmOldPassword()" autocomplete="on">
                @csrf
                @include('partials.input', [
                    'type' => 'password',
                    'label' => 'Password',
                    'name' => 'oldPassword',
                    'required' => true,
                    'toggle' => true,
                    'showError' => true,
                    'attrs' => ['wire:model.defer' => 'oldPassword'],
                ])

                <button type="submit" class="block w-full mt-4 py-2 bg-green-light text-black font-semibold rounded">Proceed</button>
            </form>
        </div>
    </div>
@elseif ($state == 1)
    <div class="flex flex-col h-full" x-data="passwordReset">
        <div class="bg-white p-6">
            <div class="block mx-auto text-xl text-center">Create new password</div>

            <div class="mt-4 mb-4 font-medium text-md">
                Choose a strong password
            </div>

            <div class="mt-2 flex justify-center mx-auto">
                <div class="inline-block font-sm space-y-2 text-gray-medium2">
                    <div class="flex gap-2">
                        <template x-if="!password.length">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path
                                    d="M7.9987 14.6666C4.3168 14.6666 1.33203 11.6818 1.33203 7.99998C1.33203 4.31808 4.3168 1.33331 7.9987 1.33331C11.6806 1.33331 14.6654 4.31808 14.6654 7.99998C14.6654 11.6818 11.6806 14.6666 7.9987 14.6666ZM7.9987 13.3333C10.9442 13.3333 13.332 10.9455 13.332 7.99998C13.332 5.05446 10.9442 2.66665 7.9987 2.66665C5.05318 2.66665 2.66536 5.05446 2.66536 7.99998C2.66536 10.9455 5.05318 13.3333 7.9987 13.3333Z"
                                    fill="#7C8286" />
                            </svg>
                        </template>
                        <template x-if="password.length && passedRules.length">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                fill="none">
                                <path
                                    d="M7.9987 14.6666C4.3168 14.6666 1.33203 11.6818 1.33203 7.99998C1.33203 4.31808 4.3168 1.33331 7.9987 1.33331C11.6806 1.33331 14.6654 4.31808 14.6654 7.99998C14.6654 11.6818 11.6806 14.6666 7.9987 14.6666ZM7.33376 10.6666L12.0478 5.9526L11.105 5.00979L7.33376 8.78105L5.44817 6.89538L4.50536 7.83825L7.33376 10.6666Z"
                                    fill="#3561E7" />
                            </svg>
                        </template>
                        <template x-if="password.length && !passedRules.length">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                fill="none">
                                <path
                                    d="M7.9987 14.6666C4.3168 14.6666 1.33203 11.6818 1.33203 7.99998C1.33203 4.31808 4.3168 1.33331 7.9987 1.33331C11.6806 1.33331 14.6654 4.31808 14.6654 7.99998C14.6654 11.6818 11.6806 14.6666 7.9987 14.6666ZM7.33203 9.99998V11.3333H8.66536V9.99998H7.33203ZM7.33203 4.66665V8.66665H8.66536V4.66665H7.33203Z"
                                    fill="#C22929" />
                            </svg>
                        </template>

                        <p class="leading-4" :class="passedRules.length ? `text-blue` : ''">At least 8 characters</p>
                    </div>
                    <div class="flex gap-2">
                        <template x-if="!password.length">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                fill="none">
                                <path
                                    d="M7.9987 14.6666C4.3168 14.6666 1.33203 11.6818 1.33203 7.99998C1.33203 4.31808 4.3168 1.33331 7.9987 1.33331C11.6806 1.33331 14.6654 4.31808 14.6654 7.99998C14.6654 11.6818 11.6806 14.6666 7.9987 14.6666ZM7.9987 13.3333C10.9442 13.3333 13.332 10.9455 13.332 7.99998C13.332 5.05446 10.9442 2.66665 7.9987 2.66665C5.05318 2.66665 2.66536 5.05446 2.66536 7.99998C2.66536 10.9455 5.05318 13.3333 7.9987 13.3333Z"
                                    fill="#7C8286" />
                            </svg>
                        </template>
                        <template x-if="password.length && passedRules.uppercase">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                fill="none">
                                <path
                                    d="M7.9987 14.6666C4.3168 14.6666 1.33203 11.6818 1.33203 7.99998C1.33203 4.31808 4.3168 1.33331 7.9987 1.33331C11.6806 1.33331 14.6654 4.31808 14.6654 7.99998C14.6654 11.6818 11.6806 14.6666 7.9987 14.6666ZM7.33376 10.6666L12.0478 5.9526L11.105 5.00979L7.33376 8.78105L5.44817 6.89538L4.50536 7.83825L7.33376 10.6666Z"
                                    fill="#3561E7" />
                            </svg>
                        </template>
                        <template x-if="password.length && !passedRules.uppercase">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                fill="none">
                                <path
                                    d="M7.9987 14.6666C4.3168 14.6666 1.33203 11.6818 1.33203 7.99998C1.33203 4.31808 4.3168 1.33331 7.9987 1.33331C11.6806 1.33331 14.6654 4.31808 14.6654 7.99998C14.6654 11.6818 11.6806 14.6666 7.9987 14.6666ZM7.33203 9.99998V11.3333H8.66536V9.99998H7.33203ZM7.33203 4.66665V8.66665H8.66536V4.66665H7.33203Z"
                                    fill="#C22929" />
                            </svg>
                        </template>

                        <p class="leading-4" :class="passedRules.uppercase ? `text-blue` : ''">At least 1 uppercase</p>
                    </div>
                    <div class="flex gap-2">
                        <template x-if="!password.length">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                fill="none">
                                <path
                                    d="M7.9987 14.6666C4.3168 14.6666 1.33203 11.6818 1.33203 7.99998C1.33203 4.31808 4.3168 1.33331 7.9987 1.33331C11.6806 1.33331 14.6654 4.31808 14.6654 7.99998C14.6654 11.6818 11.6806 14.6666 7.9987 14.6666ZM7.9987 13.3333C10.9442 13.3333 13.332 10.9455 13.332 7.99998C13.332 5.05446 10.9442 2.66665 7.9987 2.66665C5.05318 2.66665 2.66536 5.05446 2.66536 7.99998C2.66536 10.9455 5.05318 13.3333 7.9987 13.3333Z"
                                    fill="#7C8286" />
                            </svg>
                        </template>
                        <template x-if="password.length && passedRules.lowercase">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                fill="none">
                                <path
                                    d="M7.9987 14.6666C4.3168 14.6666 1.33203 11.6818 1.33203 7.99998C1.33203 4.31808 4.3168 1.33331 7.9987 1.33331C11.6806 1.33331 14.6654 4.31808 14.6654 7.99998C14.6654 11.6818 11.6806 14.6666 7.9987 14.6666ZM7.33376 10.6666L12.0478 5.9526L11.105 5.00979L7.33376 8.78105L5.44817 6.89538L4.50536 7.83825L7.33376 10.6666Z"
                                    fill="#3561E7" />
                            </svg>
                        </template>
                        <template x-if="password.length && !passedRules.lowercase">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                fill="none">
                                <path
                                    d="M7.9987 14.6666C4.3168 14.6666 1.33203 11.6818 1.33203 7.99998C1.33203 4.31808 4.3168 1.33331 7.9987 1.33331C11.6806 1.33331 14.6654 4.31808 14.6654 7.99998C14.6654 11.6818 11.6806 14.6666 7.9987 14.6666ZM7.33203 9.99998V11.3333H8.66536V9.99998H7.33203ZM7.33203 4.66665V8.66665H8.66536V4.66665H7.33203Z"
                                    fill="#C22929" />
                            </svg>
                        </template>

                        <p class="leading-4" :class="passedRules.lowercase ? `text-blue` : ''">At least 1 lowercase</p>
                    </div>
                    <div class="flex gap-2">
                        <template x-if="!password.length">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                fill="none">
                                <path
                                    d="M7.9987 14.6666C4.3168 14.6666 1.33203 11.6818 1.33203 7.99998C1.33203 4.31808 4.3168 1.33331 7.9987 1.33331C11.6806 1.33331 14.6654 4.31808 14.6654 7.99998C14.6654 11.6818 11.6806 14.6666 7.9987 14.6666ZM7.9987 13.3333C10.9442 13.3333 13.332 10.9455 13.332 7.99998C13.332 5.05446 10.9442 2.66665 7.9987 2.66665C5.05318 2.66665 2.66536 5.05446 2.66536 7.99998C2.66536 10.9455 5.05318 13.3333 7.9987 13.3333Z"
                                    fill="#7C8286" />
                            </svg>
                        </template>
                        <template x-if="password.length && passedRules.symbol">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                fill="none">
                                <path
                                    d="M7.9987 14.6666C4.3168 14.6666 1.33203 11.6818 1.33203 7.99998C1.33203 4.31808 4.3168 1.33331 7.9987 1.33331C11.6806 1.33331 14.6654 4.31808 14.6654 7.99998C14.6654 11.6818 11.6806 14.6666 7.9987 14.6666ZM7.33376 10.6666L12.0478 5.9526L11.105 5.00979L7.33376 8.78105L5.44817 6.89538L4.50536 7.83825L7.33376 10.6666Z"
                                    fill="#3561E7" />
                            </svg>
                        </template>
                        <template x-if="password.length && !passedRules.symbol">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                fill="none">
                                <path
                                    d="M7.9987 14.6666C4.3168 14.6666 1.33203 11.6818 1.33203 7.99998C1.33203 4.31808 4.3168 1.33331 7.9987 1.33331C11.6806 1.33331 14.6654 4.31808 14.6654 7.99998C14.6654 11.6818 11.6806 14.6666 7.9987 14.6666ZM7.33203 9.99998V11.3333H8.66536V9.99998H7.33203ZM7.33203 4.66665V8.66665H8.66536V4.66665H7.33203Z"
                                    fill="#C22929" />
                            </svg>
                        </template>

                        <p class="leading-4" :class="passedRules.symbol ? `text-blue` : ''">At least 1 symbol</p>
                    </div>
                </div>
            </div>

            <form class="mt-4" method="post" @submit.prevent="$wire.set('password', password); $wire.updatePassword()" autocomplete="on">
                @csrf
                <div class="mb-5">
                    @include('partials.input', [
                        'type' => 'password',
                        'label' => 'New Password',
                        'name' => 'password',
                        'required' => true,
                        'toggle' => true,
                        'showError' => true,
                        'attrs' => ['x-model' => 'password'],
                    ])
                </div>
                <div>
                    @include('partials.input', [
                        'type' => 'password',
                        'label' => 'Confirm New Password',
                        'name' => 'password_confirmation',
                        'required' => true,
                        'toggle' => false,
                        'showError' => true,
                        'attrs' => ['wire:model.defer' => 'password_confirmation'],
                    ])
                </div>

                <button type="submit" class="block w-full mt-4 py-2 bg-green-light text-black font-semibold rounded">Create Password</button>
            </form>
        </div>
    </div>
@else
    <div class="flex flex-col h-full">
        <div class="bg-white p-6">
            <div class="block mx-auto text-xl text-center">Password created successfully</div>
            <img src="{{asset('/img/check.png')}}" alt="success.png" class="block my-4 mx-auto w-[80px] h-[80px]" />
            <span class="mx-auto block text-center">Sign in to continue using Capitalyze</span>
            
            <form method="POST" action="{{ route('logout') }}" x-data>
                @csrf
                <button type="submit" class="block w-full text-center mt-4 py-2 bg-green-light text-black font-semibold rounded">Sign in</button>
            </form>
        </div>
    </div>
@endif