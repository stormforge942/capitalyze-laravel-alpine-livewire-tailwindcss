<div x-data="{
    value: [null, null],
    showDropdown: false,

    get formattedStartsAt() {
        return this.formatDate(this.value[0])
    },

    get formattedEndsAt() {
        return this.formatDate(this.value[1])
    },

    formatDate(date) {
        if (date) {
            return luxon.DateTime.fromISO(date).toFormat('LLL dd, yyyy')
        } else {
            return luxon.DateTime.now().toFormat('LLL dd, yyyy')
        }
    },

    init() {
        const div = $el.querySelector('.range-calendar-box')
        const calendar = new VanillaCalendar(div, {
            type: 'multiple',
            months: 2,
            jumpMonths: 2,
            settings: {
                visibility: { weekend: false, theme: 'light', daysOutside: false, },
                selection: { day: 'multiple-ranged', },
                selected: {
                    dates: (this.value[0] && this.value[1]) ? [`${this.value[0]}:${this.value[1]}`] : null
                }
            },
            actions: {
                clickDay: (e, dates) => {
                    if (dates.length > 1) {
                        let [start, end] = [dates[0], dates[dates.length - 1]];

                        this.value = start > end ? [end, start] : [start, end];

                        this.showDropdown = false;
                    }
                }
            }
        })

        calendar.init()
    },
}" x-modelable="value" {{ $attributes }}>
    <x-dropdown placement="bottom-end" x-model="showDropdown">
        <x-slot name="trigger">
            <div
                class="text-left text-sm border border-[#D1D3D5] rounded-lg flex relative divide-x divide-[#F3F3F3] [&>*]:px-4 bg-white">
                <div class="py-2">
                    <label class="text-[#7C8286]">From</label>
                    <p x-text="formattedStartsAt"></p>
                </div>
                <div class="py-2">
                    <label class="text-[#7C8286]">To</label>
                    <p x-text="formattedEndsAt"></p>
                </div>
                <div class="grid place-items-center">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M19 3.81818H20C21.1 3.81818 22 4.63636 22 5.63636V20.1818C22 21.1818 21.1 22 20 22H4C2.9 22 2 21.1818 2 20.1818V5.63636C2 4.63636 2.9 3.81818 4 3.81818H5V2.90909C5 2.40909 5.45 2 6 2C6.55 2 7 2.40909 7 2.90909V3.81818H17V2.90909C17 2.40909 17.45 2 18 2C18.55 2 19 2.40909 19 2.90909V3.81818ZM5 20.1818H19C19.55 20.1818 20 19.7727 20 19.2727V8.36364H4V19.2727C4 19.7727 4.45 20.1818 5 20.1818Z"
                            fill="#3561E7" />
                    </svg>
                </div>
            </div>
        </x-slot>

        <x-slot name="body">
            <div class="bg-white rounded-lg border border-blue">
                <div class="range-calendar-box"></div>
            </div>
        </x-slot>
    </x-dropdown>
</div>
