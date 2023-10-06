<div class="date-range-select-wrapper flex ml-2 relative"  wire:click="toggle">
    <div class="from-wrapper py-2 px-3 flex flex-col">
        <label class="label" for="fromCalendar">From</label>
        <div class="value">{{\Carbon\Carbon::parse($start_at)->format('M d, Y')}}</div>
    </div>
    <div class="to-wrapper py-2 px-4 flex flex-col">
        <label class="label" for="toCalendar">To</label>
        <div class="value">{{\Carbon\Carbon::parse($end_at)->format('M d, Y')}}</div>
    </div>
    <div class="calendar-icon-wrapper icon-wrapper px-4 flex items-center">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M19 3.81818H20C21.1 3.81818 22 4.63636 22 5.63636V20.1818C22 21.1818 21.1 22 20 22H4C2.9 22 2 21.1818 2 20.1818V5.63636C2 4.63636 2.9 3.81818 4 3.81818H5V2.90909C5 2.40909 5.45 2 6 2C6.55 2 7 2.40909 7 2.90909V3.81818H17V2.90909C17 2.40909 17.45 2 18 2C18.55 2 19 2.40909 19 2.90909V3.81818ZM5 20.1818H19C19.55 20.1818 20 19.7727 20 19.2727V8.36364H4V19.2727C4 19.7727 4.45 20.1818 5 20.1818Z" fill="#52D3A2"/>
        </svg>
    </div>
    @if($visible)
        <div wire:click.stop class="absolute top-12 -left-64 md:max-w-[512px] border rounded-md"  style="width: 512px; border-color: #3561E7;">
            <div id="calendar"></div>
        </div>
    @endif
</div>

@pushonce('scripts')
    <script>

        function init() {
            const calendar = new VanillaCalendar('#calendar', {
                type: 'multiple',
                settings: {
                    selection: {
                        day: 'multiple-ranged',
                    },
                },
                actions: {
                    clickDay(e, dates) {
                        if(dates.length && dates[0] !== dates[dates.length - 1]) {
                        @this.update(dates[0], dates[dates.length - 1])
                        }
                        console.log('day', e, dates)
                    },
                }
            })

            calendar.init()
        }

        Livewire.on("toggleVisibleCalendar", init);



    </script>
@endpushonce
