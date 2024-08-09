@if (!isPasswordConfirmed())
    <div class="flex flex-col h-full">
        <div class="bg-white p-6">
            <div class="block text-xl text-center">Enter Password</div>
            <div class="block text-center mt-4">Enter password to @if ($mode) enable @else disable @endif</div>
            <div class="block text-center">Two Factor Authentication</div>

            <form class="mt-4" method="post" @submit.prevent="$wire.confirmPassword()" autocomplete="on">
                @csrf
                @include('partials.input', [
                    'type' => 'password',
                    'label' => 'Password',
                    'name' => 'password',
                    'required' => true,
                    'toggle' => true,
                    'showError' => true,
                    'attrs' => ['wire:model.defer' => 'password'],
                ])

                <button type="submit" class="block w-full mt-4 py-2 bg-green-light text-black font-semibold rounded">Proceed</button>
            </form>
        </div>
    </div>
@else
    @if ($mode)
        <div class="flex flex-col h-full">
            <div class="bg-white p-6">
                <div class="block text-xl text-center">Enter Email</div>
                <div class="block text-center">Enter email address to authenticate</div>

                <form class="mt-4" method="post" @submit.prevent="$wire.confirmEmail()" autocomplete="on">
                    @csrf
                    @include('partials.input', [
                        'type' => 'email',
                        'label' => 'Email Address',
                        'name' => 'email',
                        'required' => true,
                        'toggle' => false,
                        'showError' => true,
                        'attrs' => ['wire:model.defer' => 'email'],
                    ])

                    <button type="submit" class="block w-full mt-4 py-2 bg-green-light text-black font-semibold rounded">Proceed</button>
                </form>
            </div>
        </div>
    @else
        <div x-init="$wire.close()">
            
        </div>
    @endif
@endif
