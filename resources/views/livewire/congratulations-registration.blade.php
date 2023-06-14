<div>
    <div class="p-4 bg-white rounded shadow">
        <h1 class="text-2xl font-semibold">Congratulations!</h1>
        <p class="mt-2">Thank you for registering. Here's your current status:</p>
        <ul class="list-disc pl-5 mt-2">
            <li class="{{ $isVerified ? 'text-green-500' : 'text-red-500' }}">
                Email Verification: {{ $isVerified ? 'Completed' : 'Pending' }}
            </li>
            <li class="{{ $isAdminApproved ? 'text-green-500' : 'text-red-500' }}">
                Admin Approval: {{ $isAdminApproved ? 'Completed' : 'Pending' }}
            </li>
        </ul>
        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-jet-button type="submit">
                        {{ __('Resend Verification Email') }}
                    </x-jet-button>
                </div>
            </form>

            <div>
                <a
                    href="{{ route('profile.show') }}"
                    class="underline text-sm text-gray-600 hover:text-gray-900"
                >
                    {{ __('Edit Profile') }}</a>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf

                    <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 ml-2">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
