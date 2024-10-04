<div class="w-100" x-data="{
    isEdit: @entangle('isEdit'),

    handleConfirmEdit() {
        $wire.updateInformation();
    }
}">
    <div class="flex items-center justify-between">
        <span class="text-[#2575F0] font-bold border-l-4 border-blue-500 py-2 px-2">Company Information</span>
        <button x-show="isEdit" class="bg-[#52D3A2] text-black px-4 py-2 rounded font-semibold" @click="handleConfirmEdit()">Update Information</button>
        <a x-show="! isEdit" class="underline font-bold" @click.prevent="isEdit = true;">Edit</a>
    </div>

    <div class="mt-6" :class="isEdit ? '' : 'px-4'">
        <div x-show="! isEdit">
            <div class="flex items-center justify-between border-b py-4 mb-3">
                <span class="text-dark-light2">Name of Company</span>
                <span class="text-black font-semibold flex">
                    <span class="mr-1">{{ $info->name }}</span>
                    <img src="{{ asset('img/logo1.png') }}"
                        style="height: 24px; width: 24px; border-radius: 50%; "
                        alt="company logo">
                </span>
            </div>
            <div class="flex items-center justify-between border-b py-4 mb-3">
                <span class="text-dark-light2">Official Company Email</span>
                <span class="text-black font-semibold">{{ $info->email }}</span>
            </div>
            <div class="flex items-center justify-between border-b py-4 mb-3">
                <span class="text-dark-light2">Industry</span>
                <span class="text-black font-semibold">{{ $info->industry }}</span>
            </div>
            <div class="flex items-center justify-between border-b py-4 mb-3">
                <span class="text-dark-light2">Headquarters</span>
                <span class="text-black font-semibold">{{ $info->country }}</span>
            </div>
            <div class="flex items-center justify-between border-b py-4 mb-3">
                <span class="text-dark-light2">Size</span>
                <span class="text-black font-semibold">{{ $info->companySize }}</span>
            </div>
            <div class="flex items-center justify-between border-b py-4 mb-3">
                <span class="text-dark-light2">CIK</span>
                <span class="text-black font-semibold">{{ $info->cik }}</span>
            </div>
            <div class="flex items-center justify-between border-b py-4 mb-3">
                <span class="text-dark-light2">Website</span>
                <a href="{{ $info->website }}" target="_blank" class="text-black font-semibold hover:text-blue hover:underline">{{ $info->website }}</a>
            </div>
            <div class="flex items-center justify-between border-b py-4 mb-3">
                <span class="text-dark-light2">Socials</span>
                <div class="flex gap-4">
                    @if ($info->linkedin_link)
                    <a href="{{ $info->linkedin_link }}"
                        target="_blank">
                        <img src="{{ asset('img/linkedin.png') }}"
                            style="height: 32px; width: 32px; border-radius: 50%; "
                            alt="linkedin logo">
                    </a>
                    @endif
                    @if ($info->facebook_link)
                    <a href="{{ $info->facebook_link }}" target="_blank">
                        <img src="{{ asset('img/facebook.png') }}"
                            style="height: 32px; width: 32px; border-radius: 50%; "
                            alt="facebook logo">
                    </a>
                    @endif
                    @if ($info->twitter_link)
                    <a href="{{ $info->twitter_link }}" target="_blank">
                        <img src="{{ asset('img/twitter.png') }}"
                            style="height: 32px; width: 32px; border-radius: 50%; "
                            alt="twitter logo">
                    </a>
                    @endif
                </div>
            </div>
        </div>

        <div x-show="isEdit">
            <form x-ref="formRef">
                <div class="mb-4">
                    @include('partials.input', [
                        'label' => 'Name of Company',
                        'name' => 'companyName',
                        'type' => 'text',
                        'attrs' => ['wire:model.defer' => 'companyName'],
                    ])
                </div>
                <div class="mb-4">
                @include('partials.input', [
                    'label' => 'Official Company Email',
                    'name' => 'companyEmail',
                    'type' => 'text',
                    'attrs' => ['wire:model.defer' => 'companyEmail'],
                ])
                </div>
                <div class="mb-4">
                @include('partials.select', [
                    'label' => 'Industry',
                    'name' => 'companyIndustry',
                    'type' => 'select',
                    'options' => ['Agriculture', 'Automotive', 'Banking', 'Construction', 'Consulting', 'Education', 'Energy', 'Entertainment', 'Financial Services', 'Food & Beverage', 'Healthcare', 'Hospitality', 'Information Technology', 'Insurance', 'Legal', 'Manufacturing', 'Marketing', 'Media', 'Non-profit', 'Pharmaceutical', 'Real Estate', 'Retail', 'Telecommunications', 'Transportation', 'Utilities', 'Other'],
                    'attrs' => ['wire:model.defer' => 'companyIndustry'],
                ])
                </div>
                <div class="mb-4">
                @include('partials.select', [
                    'label' => 'Location of HQ',
                    'name' => 'headquarters',
                    'type' => 'select',
                    'options' => $countries,
                    'filterable' => true,
                    'attrs' => ['wire:model.defer' => 'headquarters'],
                ])
                </div>
                <div class="mb-4">
                @include('partials.input', [
                    'label' => 'Company Size',
                    'name' => 'employees',
                    'type' => 'text',
                    'attrs' => ['wire:model.defer' => 'employees'],
                ])
                </div>
                <div class="mb-4">
                @include('partials.input', [
                    'label' => 'CIK',
                    'name' => 'cik',
                    'type' => 'text',
                    'attrs' => ['wire:model.defer' => 'cik'],
                ])
                </div>
                <div class="mb-4">
                @include('partials.input', [
                    'label' => 'Official Website',
                    'name' => 'companyWebsite',
                    'type' => 'text',
                    'attrs' => ['wire:model.defer' => 'companyWebsite'],
                ])
                </div>
                
                <span class="block mb-3 text-md font-semibold">Socials</span>
                <div class="mb-4">
                @include('partials.input', [
                    'label' => 'Linkedin',
                    'name' => 'companyLinkedin',
                    'type' => 'text',
                    'attrs' => ['wire:model.defer' => 'companyLinkedin'],
                    'icon' => 'img/linkedin.png',
                ])
                </div>
                <div class="mb-4">
                @include('partials.input', [
                    'label' => 'Facebook',
                    'name' => 'companyFacebook',
                    'type' => 'text',
                    'attrs' => ['wire:model.defer' => 'companyFacebook'],
                    'icon' => 'img/facebook.png',
                ])
                </div>
                <div class="mb-4">
                @include('partials.input', [
                    'label' => 'Twitter / X',
                    'name' => 'companyTwitter',
                    'type' => 'text',
                    'attrs' => ['wire:model.defer' => 'companyTwitter'],
                    'icon' => 'img/twitter.png',
                ])
                </div>
            </form>
        </div>
    </div>
</div>
