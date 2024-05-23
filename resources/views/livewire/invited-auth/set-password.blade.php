<div x-data="passwordReset">
    @if($isValidToken)
        <div class="text-center mt-2">
            <h1 class="text-2xl font-semibold">Create Password</h1>

            <div class="mt-4 text-[#DA680B] font-medium">
                Create your password to start using Capitalyze
            </div>

            <div class="mt-4 mb-4 font-medium text-md">
                Choose a strong password
            </div>
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

        <form class="mt-6" method="post" action="{{ route('password.update', ['flow' => 'create-password', 'user' => $user->id]) }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $user->email }}">

            @include('partials.input', [
                'type' => 'password',
                'label' => 'New password',
                'name' => 'password',
                'required' => true,
                'autofocus' => true,
                'attrs' => ['x-model' => 'password', 'autocomplete' => 'off'],
                'toggle' => true,
            ])

            @error('email')
            <p class="mt-1 text-sm text-danger px-4">
                The password set link has expired. Please request a new one from <a
                    href="{{ route('password.request') }}" class="underline">here</a>.
            </p>
            @enderror

            @include('partials.input', [
                'type' => 'password',
                'class' => 'mt-6',
                'label' => 'Confirm Password',
                'name' => 'password_confirmation',
                'required' => true,
                'attrs' => ['autocomplete' => 'off'],
            ])

            <div class="mt-6 text-center">
                @include('partials.green-button', [
                    'text' => 'Create Password',
                    'type' => 'submit',
                ])
            </div>

            <div class="mt-5 text-center">
                Already have an account? <a href="{{ route('login') }}" class="font-semibold underline hover:bg-green-light2 rounded p-1 -mx-0.5 transition-all">Sign In</a>
            </div>

            <div class="mt-5 mb-2 text-center">
                Don't have an account? <a href="{{ route('waitlist.join') }}" class="font-semibold underline hover:bg-green-light2 rounded p-1 -mx-0.5 transition-all">Join the waitlist</a>
            </div>
        </form>
    @else
        <div class="text-center">
            <h1 class="text-2xl font-semibold">Password set link is invalid</h1>

            <p class="mt-3 text-[#DA680B] font-medium">
                You can request a new link instead
            </p>
        </div>
    @endif
</div>
