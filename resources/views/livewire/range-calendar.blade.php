<div class="date-range-select-wrapper border-2 border-[#F3F3F3] rounded-lg flex relative divide-x"  wire:click="toggle">
    <div class="from-wrapper py-2 px-3 flex flex-col">
        <label class="calendar-label" for="fromCalendar">From</label>
        <div class="value">{{\Carbon\Carbon::parse($start_at)->format('M d, Y')}}</div>
    </div>
    <div class="to-wrapper py-2 px-4 flex flex-col">
        <label class="calendar-label" for="toCalendar">To</label>
        <div class="value">{{\Carbon\Carbon::parse($end_at)->format('M d, Y')}}</div>
    </div>
    <div class="calendar-icon-wrapper icon-wrapper px-4 flex items-center">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M19 3.81818H20C21.1 3.81818 22 4.63636 22 5.63636V20.1818C22 21.1818 21.1 22 20 22H4C2.9 22 2 21.1818 2 20.1818V5.63636C2 4.63636 2.9 3.81818 4 3.81818H5V2.90909C5 2.40909 5.45 2 6 2C6.55 2 7 2.40909 7 2.90909V3.81818H17V2.90909C17 2.40909 17.45 2 18 2C18.55 2 19 2.40909 19 2.90909V3.81818ZM5 20.1818H19C19.55 20.1818 20 19.7727 20 19.2727V8.36364H4V19.2727C4 19.7727 4.45 20.1818 5 20.1818Z" fill="#3561E7"/>
        </svg>
    </div>
    @if($visible)
        <div wire:click.stop class="absolute-top-70  md:max-w-[556px] border rounded-md flex flex-row justify-between bg-white text-dark"  style="width: 556px; border-color: #3561E7;">
            <div id="fromCalendar"></div>
            <div id="toCalendar"></div>
        </div>
    @endif
</div>

@pushonce('scripts')
    <script>
        const today = new Date()
        const tomorrow = new Date(today);
        tomorrow.setDate(today.getDate() + 1);

        const year = today.getFullYear()
        const month = String(today.getMonth() + 1).padStart(2, '0')
        const day = String(today.getDate()).padStart(2, '0')

        const tomorrow_year = tomorrow.getFullYear();
        const tomorrow_month = String(tomorrow.getMonth() + 1).padStart(2, '0');
        const tomorrow_day = String(tomorrow.getDate()).padStart(2, '0');

        const tomorrowDisabledDate = `${tomorrow_year}-${tomorrow_month}-${tomorrow_day}:2048-12-31`
        const todayDisabledDate = `${year}-${month}-${day}:2048-12-31`

        let start_at = null;
        let end_at = null;

        let from_calendar_month = new Date().getMonth();
        let from_calendar_year = new Date().getFullYear();

        let to_calendar_month = new Date().getMonth();
        let to_calendar_year = new Date().getFullYear();

        function init() {
            start_at = null;
            end_at = null;
            const fromCalendar = new VanillaCalendar('#fromCalendar', {
                settings: {
                    visibility: {
                        weekend: false,
                        today: false,
                    },
                    range: {
                        // disabled: [todayDisabledDate],
                    },
                    selected: {
                        month: from_calendar_month,
                        year: from_calendar_year,
                    },
                },
                actions: {
                    clickDay(e, dates) {
                        return changeDate(e, dates, true)
                    }
                }
            })

            const toCalendar = new VanillaCalendar('#toCalendar', {
                settings: {
                    visibility: {
                        weekend: false,
                    },
                    range: {
                        // disabled: [tomorrowDisabledDate],
                    },
                    selected: {
                        month: to_calendar_month,
                        year: to_calendar_year,
                    },
                },
                actions: {
                    clickDay(e, dates) {
                        return changeDate(e, dates, false)
                    }
                }
            })

            fromCalendar.init()
            toCalendar.init()
        }

        const changeDate = (e, dates, start) => {
            if(start) {
                start_at = dates[0]
            } else {
                end_at = dates[0]
            }

            if (start_at && end_at) {
                from_calendar_month = new Date(start_at).getMonth();
                from_calendar_year = new Date(start_at).getFullYear();
                to_calendar_month = new Date(end_at).getMonth();
                to_calendar_year = new Date(end_at).getFullYear();

                if (new Date(start_at) < new Date(end_at)) {
                    console.log(start_at, end_at)
                    @this.update(start_at, end_at)
                }
            }
        }

        Livewire.on("toggleVisibleCalendar", init);
    </script>
@endpushonce
