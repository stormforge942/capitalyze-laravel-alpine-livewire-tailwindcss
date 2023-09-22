<div>
    <livewire:company-segment-report-table/>
    @if($openFileExplorer)
        @livewire('file-explorer', $filesIds)
    @endif
    @if($openSlider)
        <livewire:company-segment-report-update-slider :reportId="$reportId"/>
    @endif
</div>
