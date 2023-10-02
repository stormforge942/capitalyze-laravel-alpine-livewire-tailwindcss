<div>
    @include('partials.auth-header', ['title' => 'Sign In', 'badge' => true])
    <form class="mt-4" wire:submit.prevent="login">
        @include('partials.input', [
        'type' => 'email',
        'label' => 'Work Email',
        'wire' => 'email',
        ])

        @include('partials.input', [
        'type' => 'password',
        'class' => 'mt-6',
        'label' => 'Password',
        'wire' => 'password',
        ])

        <div class="mt-4 flex justify-between items-center text-sm">
            <label class="flex items-center gap-1.5">
                <input type="checkbox" value="on" class="text-black border-2 border-black h-4 w-4 rounded-sm focus:ring-black"
                    wire:model.defer="remember">
                <span>Remember Me</span>
            </label>
            <a href="{{ route('password.request') }}">Forgot Password?</a>
        </div>

        <div class="mt-6 text-center">
            @include('partials.green-button', ['text' => 'Sign In', 'type' => 'submit'])

            <a href="{{ route('register') }}" class="mt-4 inline-block">
                Don't have an account? <span class="font-semibold">Join the waitlist</span>
            </a>
        </div>
    </form>
</div>