<div>
    @include('partials.auth-header', ['title' => 'Confirm Email'])

    <p class="mt-4 text-[#DA680B] text-center text-base">
        Enter your email to confirm if you have been approved
    </p>

    @if($isWrong)
        <div class="text-center text-danger mt-4 text-base">
            Email is incorrect
        </div>
    @endif

    <form class="mt-4" wire:submit.prevent="checkEmail" autocomplete="on">
        @csrf

        @include('partials.input', [
            'type' => 'email',
            'label' => 'Email',
            'class' => $isWrong ? 'border-danger' : '',
            'name' => 'email',
            'required' => true,
            'autofocus' => $isWrong,
            'attrs' => ['autocomplete' => 'email', 'wire:model.defer' => 'email'],
            'showError' => false,
        ])

        <div class="mt-6 text-center text-base">
            @include('partials.green-button', [
                'text' => 'Verify',
                'type' => 'submit',
            ])

            <div class="mt-4 inline-block">
                Already have an account? <a href="{{ route('login') }}" class="font-semibold underline hover:bg-green-light2 rounded p-1 -mx-0.5 transition-all">Sign In</a>
            </div>

            <div class="mt-4 inline-block">
                Don't have an account? <a href="{{ route('waitlist.join') }}" class="font-semibold underline hover:bg-green-light2 rounded p-1 -mx-0.5 transition-all">Join the waitlist</a>
            </div>
        </div>
    </form>
</div>
