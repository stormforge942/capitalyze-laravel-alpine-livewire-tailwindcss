<div class="flex flex-col">
    <!-- just for responsive view  -->
    <livewire:all-filings.common-layout key="{{ now() }}" :selectChecked="$selectChecked" :checkedCount="$checkedCount" :data="$data" :filtered="$filtered" :company="$company"/>
</div>
