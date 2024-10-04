<div class="w-100" x-data="{
    isEdit: $wire.entangle('isEdit', true),

    confirmUpdate() {
        $wire.updateProfile().then(() => location.reload());
    },

    handleFileUpload(event) {
        $wire.upload('profilePhoto', event.target.files[0]);
    },
}">
    <div class="flex items-center justify-between">
        <span class="text-[#2575F0] font-bold border-l-4 border-blue-500 py-2 px-2">Profile Information</span>

        <button class="bg-[#52D3A2] text-black px-4 py-2 rounded font-bold" @click="confirmUpdate()" x-cloak
            x-show="isEdit">
            Confirm Update
        </button>

        <a class="underline font-bold" @click.prevent="isEdit = true;" x-show="!isEdit">Edit</a>
    </div>

    <div class="mt-3 px-6">
        <div class="my-6">
            <p class="text-xl">Profile Photo</p>
            <div class="w-[120px] h-[120px] text-[50px] my-2 mr-2">
                @if ($profilePhoto)
                    <img src="{{ $profilePhoto->temporaryUrl() }}" alt="Profile Photo"
                        class="rounded-full w-full h-full" />
                @elseif ($user->profile_photo_path)
                    <img src="{{ $user->profile_photo_url }}" alt="Profile Photo"
                        class="rounded-full w-full h-full">
                @else
                    <div
                        class="bg-[#121A0F] text-[#DCF6EC] w-full h-full flex shrink-0 text-center items-center justify-center rounded-full">
                        {{ $user->initials }}
                    </div>
                @endif
            </div>
            <div x-show="isEdit" x-cloak>
                <input type="file" id="file-upload" class="hidden" @change="handleFileUpload">
                <label for="file-upload" class="bg-green-light font-semibold px-4 py-1 rounded cursor-pointer">
                    <span>Upload Image</span>
                </label>
            </div>
        </div>

        <form @submit.prevent="" x-cloak x-show="isEdit">
            <div class="mb-4">
                @include('partials.input', [
                    'label' => 'Full Name',
                    'name' => 'name',
                    'type' => 'text',
                    'attrs' => ['wire:model.defer' => 'name'],
                ])
            </div>
            <div class="mb-4">
                @include('partials.input', [
                    'label' => 'Email',
                    'name' => 'email',
                    'type' => 'email',
                    'attrs' => ['wire:model.defer' => 'email'],
                ])
            </div>
            <div class="mb-4">
                @include('partials.input', [
                    'label' => 'Job Title',
                    'name' => 'job',
                    'type' => 'text',
                    'attrs' => ['wire:model.defer' => 'job'],
                ])
            </div>
            <div class="mb-4">
                @include('partials.datepicker', [
                    'label' => 'Date of Birth',
                    'name' => 'dob',
                    'attrs' => ['wire:model.defer' => 'dob'],
                ])
            </div>
            <div class="mb-4">
                @include('partials.select', [
                    'label' => 'Country',
                    'name' => 'country',
                    'type' => 'select',
                    'options' => $countries,
                    'filterable' => true,
                    'attrs' => ['wire:model.defer' => 'country'],
                ])
            </div>
            <span class="block mb-3 text-md font-semibold">Socials</span>
            <div class="mb-4">
                @include('partials.input', [
                    'label' => 'Linkedin',
                    'name' => 'linkedin',
                    'type' => 'text',
                    'attrs' => ['wire:model.defer' => 'linkedin_link'],
                    'icon' => 'img/linkedin.png',
                ])
            </div>
            <div class="mb-4">
                @include('partials.input', [
                    'label' => 'Facebook',
                    'name' => 'facebook',
                    'type' => 'text',
                    'attrs' => ['wire:model.defer' => 'facebook_link'],
                    'icon' => 'img/facebook.png',
                ])
            </div>
            <div class="mb-4">
                @include('partials.input', [
                    'label' => 'Twitter / X',
                    'name' => 'twitter',
                    'type' => 'text',
                    'attrs' => ['wire:model.defer' => 'twitter_link'],
                    'icon' => 'img/twitter.png',
                ])
            </div>
        </form>

        <div class="space-y-3" x-show="!isEdit"> 
            <div class="flex items-center justify-between border-b py-4">
                <span class="text-dark-light2">Full Name</span>
                <span class="text-black font-bold">{{ $user->name }}</span>
            </div>
            <div class="flex items-center justify-between border-b py-4">
                <span class="text-dark-light2">Official Email</span>
                <span class="text-black font-bold">{{ $user->email }}</span>
            </div>
            <div class="flex items-center justify-between border-b py-4">
                <span class="text-dark-light2">Job Title</span>
                <span class="text-black font-bold">{{ $user->job }}</span>
            </div>
            <div class="flex items-center justify-between border-b py-4">
                <span class="text-dark-light2">Date of Birth</span>
                <span class="text-black font-bold">{{ $user->dob }}</span>
            </div>
            <div class="flex items-center justify-between border-b py-4">
                <span class="text-dark-light2">Country</span>
                <span class="text-black font-bold">{{ $user->country }}</span>
            </div>

            <div class="flex items-center justify-between border-b py-4">
                <span class="text-dark-light2">Socials</span>
                <div class="flex gap-4">
                    <a x-show="$wire.linkedin_link" href="{{ $user->linkedin_link }}" target="_blank">
                        <img src="{{ asset('img/linkedin.png') }}"
                            style="height: 32px; width: 32px; border-radius: 50%; " alt="linkedin logo" />
                    </a>
                    <a x-show="$wire.facebook_link" href="{{ $user->facebook_link }}" target="_blank">
                        <img src="{{ asset('img/facebook.png') }}"
                            style="height: 32px; width: 32px; border-radius: 50%; " alt="facebook logo" />
                    </a>
                    <a x-show="$wire.twitter_link" href="{{ $user->twitter_link }}" target="_blank">
                        <img src="{{ asset('img/twitter.png') }}"
                            style="height: 32px; width: 32px; border-radius: 50%; " alt="twitter logo" />
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
