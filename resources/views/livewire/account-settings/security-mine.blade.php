<div class="w-100" x-data="{
    enableTwoStepVerification() {
        Livewire.emit('modal.open', 'account-settings.two-factor-authentication', {mode: true});
    },
    disableTwoStepVerification() {
        if ($wire.passwordConfirmed) {
            this.$wire.disableTwoFactorAuthentication();
        }
        else Livewire.emit('modal.open', 'account-settings.two-factor-authentication', {mode: false});
    }
}">
    <div class="flex items-center justify-between">
        @if ($isDeviceShow)
            <button class="flex" @click="$wire.isDeviceShow = false;"><img class="mr-2" src="{{ asset('svg/left.svg') }}" alt="Left Icon" /><span class="underline font-bold">Go Back</span></button>
            <span class="text-blue">Devices</span>
        @else
            <span class="text-[#2575F0] font-bold border-l-4 border-blue-500 py-2 px-2">Security</span>
        @endif
    </div>

    <div class="mt-3 px-3">
        @if ($isDeviceShow)
            <h2 class="my-4 font-bold text-lg">List of devices</h2>

            @foreach ($sessions as $session)
                <div class="flex items-center justify-between py-3 border-b">
                    <div>
                        <h6 class="text-md font-semibold mb-1">
                            {{ $session['agent']['platform'] }}
                            @if ($session['is_current_device'])
                                <span class="text-blue">(This device)</span>
                            @endif
                        </h6>
                        <p class="text-sm text-black">
                            {{ $session['last_active'] }} • {{ $session['ip_location'] }} • {{ $session['ip_address'] }} • {{ $session['agent']['browser'] }}
                        </p>
                    </div>
                    <button class="bg-red-500 text-white px-4 py-1 rounded" @click="$wire.revokeDevice('{{ $session['id'] }}')">Revoke</button>
                </div>
            @endforeach
        @else
            <div class="flex items-center justify-between py-3 border-b">
                <div>
                    <h6 class="text-md font-semibold mb-1">Password</h6>
                    <p class="text-sm text-gray-500">You can update your password</p>
                </div>
                <button class="bg-green-100 text-green-700 px-4 py-1 rounded font-bold" @click="Livewire.emit('modal.open', 'account-settings.password-reset')">Update</button>
            </div>

            <div class="flex items-center justify-between py-3 border-b">
                <div>
                    <h6 class="text-md font-semibold mb-1">Two Factor Authentication</h6>
                    @if (! $tfa_enabled)
                        <p class="text-sm text-[#DA680B]">Activate Two Factor Authenticatioin for more security</p>
                    @else
                        <p class="text-sm text-green">Currently Active</p>
                    @endif
                </div>
                @if (! $tfa_enabled)
                    <button class="bg-[#DA680B] text-white px-4 py-1 rounded font-bold" @click="enableTwoStepVerification()">Enable</button>
                @else
                    <button class="bg-[#DA680B] text-white px-4 py-1 rounded font-bold" @click="disableTwoStepVerification()">Disable</button>
                @endif
            </div>

            <div class="flex items-center justify-between py-3 border-b">
                <div>
                    <h6 class="text-md font-semibold mb-1">Devices</h6>
                    <p class="text-sm text-gray-500">You can update your password</p>
                </div>
                <button class="bg-green-100 text-green-700 px-4 py-1 rounded font-bold" @click="$wire.isDeviceShow = true;">Check</button>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('openNewPasswordModal', () => {
            Livewire.emit('modal.open', 'account-settings.new-password-input');
        });
        Livewire.on('passwordChangedModal', () => {
            Livewire.emit('modal.open', 'account-settings.password-reset-success');
        });
        Livewire.on('closeModal', function () {
            document.dispatchEvent(new CustomEvent('close-modal'));
        });
    });
</script>
@endpush