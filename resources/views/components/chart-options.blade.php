<div class="py-4 text-sm+ w-52">
    <div class="[&>*]:px-4 [&>*]:w-full [&>*]:p-2 [&>*]:text-left">
        {{ $top ?? '' }}
        @if($toggleFeature)
        <button class="hover:bg-gray-100" @click="hide = !hide; dropdown.hide();"
            x-text="hide ? 'Show Chart' : 'Hide Chart'"></button>
        @endif
        <button class="hover:bg-gray-100" @click="dropdown.hide(); $dispatch('full-screen')">View in Full Screen</button>
        <button class="hover:bg-gray-100" @click="dropdown.hide(); $dispatch('print-chart')">Print Chart</button>
    </div>
    <hr class="my-4">
    <div class="[&>*]:px-4 [&>*]:w-full [&>*]:p-2">
        <button type="button" class="hover:bg-gray-100 flex items-center gap-x-2" @click="dropdown.hide(); $dispatch('download-chart', 'pdf')">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M8.66927 6.66667H12.0026L8.0026 10.6667L4.0026 6.66667H7.33594V2H8.66927V6.66667ZM2.66927 12.6667H13.3359V8H14.6693V13.3333C14.6693 13.7015 14.3708 14 14.0026 14H2.0026C1.63442 14 1.33594 13.7015 1.33594 13.3333V8H2.66927V12.6667Z"
                    fill="#121A0F" />
            </svg>

            <span>Download as PDF</span>
        </button>
        <button type="button" class="hover:bg-gray-100 flex items-center gap-x-2" @click="dropdown.hide(); $dispatch('download-chart', 'jpeg')">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M8.66927 6.66667H12.0026L8.0026 10.6667L4.0026 6.66667H7.33594V2H8.66927V6.66667ZM2.66927 12.6667H13.3359V8H14.6693V13.3333C14.6693 13.7015 14.3708 14 14.0026 14H2.0026C1.63442 14 1.33594 13.7015 1.33594 13.3333V8H2.66927V12.6667Z"
                    fill="#121A0F" />
            </svg>

            <span>Download as JPEG</span>
        </button>
        <button type="button" class="hover:bg-gray-100 flex items-center gap-x-2" @click="dropdown.hide(); $dispatch('download-chart', 'png')">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M8.66927 6.66667H12.0026L8.0026 10.6667L4.0026 6.66667H7.33594V2H8.66927V6.66667ZM2.66927 12.6667H13.3359V8H14.6693V13.3333C14.6693 13.7015 14.3708 14 14.0026 14H2.0026C1.63442 14 1.33594 13.7015 1.33594 13.3333V8H2.66927V12.6667Z"
                    fill="#121A0F" />
            </svg>

            <span>Download as PNG</span>
        </button>
    </div>
</div>
