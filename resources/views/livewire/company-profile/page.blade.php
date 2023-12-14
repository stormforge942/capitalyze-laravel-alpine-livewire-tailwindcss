<div class="company-profile-page">
    <x-company-info-header :company="['name' => $company->name, 'ticker' => $company->ticker]" />

    <div class="mt-6">
        <livewire:tabs :tabs="$tabs" :data="$tabData" :ssr="false">
    </div>
</div>

@push('scripts')
    <script>
        function smoothScroll(id) {
            let e = document.getElementById(id);
            if (e) {
                e.scrollIntoView({
                    block: 'start',
                    behavior: 'smooth',
                    inline: 'start'
                });
            }
        }

        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    </script>
@endpush
