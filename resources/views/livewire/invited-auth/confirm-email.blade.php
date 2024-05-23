<div class="text-center" x-data="emailVerification">
    @if(!$user)
        <div class="text-center py-4">
            <h1 class="text-2xl font-semibold">Session not found</h1>

            <p class="mt-5 text-[#DA680B] font-medium">
                Try to return to login page and fill form again
            </p>
        </div>
    @else
        @if($isVerified && !$isAdminApproved)
            <div class="text-center py-4">
                <h1 class="text-2xl font-semibold">Your email has been verified</h1>

                <p class="mt-5 text-[#DA680B] font-medium">
                    We’ll send you an email once your account has been approved to access <span class="text-black">Capitalyze</span>
                </p>
            </div>
        @endif

        @if($isVerified && $isAdminApproved && !$isPasswordSet)
            <div class="text-center mb-5 mt-2">
                <svg class="inline-block" width="54" height="54" viewBox="0 0 54 54" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M26.9987 53.6666C12.2711 53.6666 0.332031 41.7274 0.332031 26.9999C0.332031 12.2723 12.2711 0.333252 26.9987 0.333252C41.7262 0.333252 53.6654 12.2723 53.6654 26.9999C53.6654 41.7274 41.7262 53.6666 26.9987 53.6666ZM24.339 37.6666L43.1952 18.8104L39.424 15.0392L24.339 30.1242L16.7966 22.5815L13.0253 26.353L24.339 37.6666Z" fill="#52D3A2"/>
                </svg>
            </div>

            <h1 class="text-2xl font-semibold">Password Not Set</h1>

            <p class="mt-3 text-[#DA680B] font-medium">
                We have sent you a password setting email. If you did you not receive an email in your inbox, check your spam folder
            </p>

            <div class="mt-6 text-center">
                <button x-show="!isRequestSent" wire:click="resetPassword" wire:loading.attr="disabled" class="block w-full px-4 py-3 bg-green-dark hover:bg-green-light2 font-semibold rounded disabled:bg-green-light4 disabled:pointer-events-none transition">
                    <span wire:loading wire:target="resend">{{ __('Sending...') }}</span>
                    <span wire:loading.remove="" wire:target="resend">
                        {{ session('message') ?? __('Reset Password') }}
                    </span>
                </button>

                <button x-show="isRequestSent" type="submit" disabled="true" class="flex justify-center w-full px-4 py-3 bg-green-dark hover:bg-green-light2 font-semibold rounded disabled:bg-green-light4 disabled:pointer-events-none transition">
                    <svg class="inline mr-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 20C4.47715 20 0 15.5228 0 10C0 4.47715 4.47715 0 10 0C15.5228 0 20 4.47715 20 10C20 15.5228 15.5228 20 10 20ZM9.0026 14L16.0737 6.92893L14.6595 5.51472L9.0026 11.1716L6.17421 8.3431L4.75999 9.7574L9.0026 14Z" fill="#121A0F"/>
                    </svg>

                    {{ __('Reset password link has been sent') }}
                </button>

                <p x-show="isRequestSent" x-text="`{{ __('You can send a new password reset link in ${countdown} secs') }}`" class="mt-3 text-sm text-[#DA680B] font-medium"></p>
            </div>
        @endif

        @if($isVerified && $isAdminApproved && $isPasswordSet)
            <div class="text-center mb-5 mt-2">
                <svg class="inline-block" width="54" height="54" viewBox="0 0 54 54" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M26.9987 53.6666C12.2711 53.6666 0.332031 41.7274 0.332031 26.9999C0.332031 12.2723 12.2711 0.333252 26.9987 0.333252C41.7262 0.333252 53.6654 12.2723 53.6654 26.9999C53.6654 41.7274 41.7262 53.6666 26.9987 53.6666ZM24.339 37.6666L43.1952 18.8104L39.424 15.0392L24.339 30.1242L16.7966 22.5815L13.0253 26.353L24.339 37.6666Z" fill="#52D3A2"/>
                </svg>
            </div>

            <h1 class="text-2xl font-semibold">Your email has been verified</h1>

            <p class="mt-3 text-[#DA680B] font-medium">
                Sign in to continue using <span class="text-black">Capitalyze</span>
            </p>

            <form action="{{ route('login') }}" method="GET">
                <div class="mt-4 text-center">
                    @include('partials.green-button', [
                        'text' => 'Sign In',
                        'type' => 'submit',
                    ])
                </div>
            </form>
        @endif

        @if(!$isVerified)
            <h1 class="text-2xl font-semibold">{{ __('Verify your email') }}</h1>

            <p class="mt-1">{{ __('You have successfully registered on Capitalyze.') }}</p>

            <p class="mt-3 text-[#DA680B] font-medium">
                {{ __('A new verification link has already been sent to :email. Verify your email to continue', ['email' => $email]) }}
            </p>

            <div class="mt-6 text-center">
                <button x-show="!isRequestSent" wire:click="resend" wire:loading.attr="disabled" class="block w-full px-4 py-3 bg-green-dark hover:bg-green-light2 font-semibold rounded disabled:bg-green-light4 disabled:pointer-events-none transition">
                    <span wire:loading wire:target="resend">{{ __('Sending...') }}</span>
                    <span wire:loading.remove="" wire:target="resend">
                        {{ session('message') ?? __('Resend Verification Email') }}
                    </span>
                </button>

                <button x-show="isRequestSent" type="submit" disabled="true" class="flex justify-center w-full px-4 py-3 bg-green-dark hover:bg-green-light2 font-semibold rounded disabled:bg-green-light4 disabled:pointer-events-none transition">
                    <svg class="inline mr-2" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 20C4.47715 20 0 15.5228 0 10C0 4.47715 4.47715 0 10 0C15.5228 0 20 4.47715 20 10C20 15.5228 15.5228 20 10 20ZM9.0026 14L16.0737 6.92893L14.6595 5.51472L9.0026 11.1716L6.17421 8.3431L4.75999 9.7574L9.0026 14Z" fill="#121A0F"/>
                    </svg>

                    {{ __('Verification link has been sent') }}
                </button>
            </div>

            <p x-show="isRequestSent" x-text="`{{ __('You can send a new verification link in ${countdown} secs') }}`" class="mt-3 text-sm text-[#DA680B] font-medium"></p>
        @endif
    @endif
</div>

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('emailVerification', () => ({
                isRequestSent: false,
                countdown: 0,
                interval: null,
                init() {
                    Livewire.on('verificationEmailSent', () => {
                        this.startCountdown();
                    });

                    Livewire.on('passwordResetSent', () => {
                        this.startCountdown();
                    });
                },
                startCountdown() {
                    this.isRequestSent = true;
                    this.countdown = 60;
                    this.interval = setInterval(() => {
                        this.countdown--;

                        if (this.countdown <= 0) {
                            clearInterval(this.interval);

                            this.isRequestSent = false;
                        }
                    }, 1000);
                }
            }))
        });
    </script>
@endpush
