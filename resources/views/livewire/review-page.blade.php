<div>
    <livewire:company-segment-report-table/>
    @if($openSlider)
        <livewire:company-segment-report-update-slider :reportId="$reportId"/>
    @endif
</div>
