import DateRangePicker from 'flowbite-datepicker/DateRangePicker';

document.addEventListener('DOMContentLoaded', () => {
    let startDate, endDate; // Declare the variables here

    const dateRangePickerEl = document.querySelector('[date-rangepicker]');
    let dateRangePicker; // Declare dateRangePicker here

    if(dateRangePickerEl !== null) {
        dateRangePicker = new DateRangePicker(dateRangePickerEl, {
            today: true,
            clearBtn: true,
        });

        const startDateInput = dateRangePickerEl.querySelector('input[name="start"]');
        const endDateInput = dateRangePickerEl.querySelector('input[name="end"]');

        function handleDateChange(e) {
            if(e.detail.date == undefined) {
                handleClearDate();
            }
            const startDateInput = document.getElementById('start-date-input'); // Replace with your actual ID
            const endDateInput = document.getElementById('end-date-input'); // Replace with your actual ID
            let startDate = startDateInput.value;
            let endDate = endDateInput.value;

            if (startDate && endDate) {
                window.livewire.emit('dateRangeChanged', { start: startDate, end: endDate });
            }
        }

        function handleClearDate() {
            window.livewire.emit('dateRangeCleared');
        }

        startDateInput.addEventListener('changeDate', handleDateChange);
        endDateInput.addEventListener('changeDate', handleDateChange);
        startDateInput.addEventListener('clearDate', handleClearDate);
        endDateInput.addEventListener('clearDate', handleClearDate);
        }
});

document.addEventListener('DOMContentLoaded', () => {
    var simulateClick = function (elem) {
        // Create our event (with options)
        var evt = new MouseEvent('click', {
            bubbles: true,
            cancelable: true,
            view: window
        });
        // If cancelled, don't dispatch our event
        var canceled = !elem.dispatchEvent(evt);
    };
    let startDate, endDate; // Declare the variables here

    const dateRangePickerEl = document.querySelector('.graph-range-picker');
    let dateRangePicker; // Declare dateRangePicker here

    if(dateRangePickerEl !== null) {
        dateRangePicker = new DateRangePicker(dateRangePickerEl, {
            today: true,
            clearBtn: true,
        });
        window.graphDateRangePicker = dateRangePicker;

        const startDateInput = dateRangePickerEl.querySelector('input[name="start"]');
        const endDateInput = dateRangePickerEl.querySelector('input[name="end"]');
        document.querySelector(".from-wrapper").addEventListener('click', function() {
            simulateClick(document.querySelector('input[name=start]'));
        });

        function handleDateChange(e) {
            if(e.detail.date == undefined) {
                handleClearDate();
            }
            const startDateInput = document.getElementById('start-date-input'); // Replace with your actual ID
            const endDateInput = document.getElementById('end-date-input'); // Replace with your actual ID
            let startDate = startDateInput.value;
            let endDate = endDateInput.value;

            if (startDate && endDate) {
                window.livewire.emit('dateRangeChanged', { start: startDate, end: endDate });
            }
        }

        function handleClearDate() {
            window.livewire.emit('dateRangeCleared');
        }
        /*
                        startDateInput.addEventListener('changeDate', handleDateChange);
                        endDateInput.addEventListener('changeDate', handleDateChange);
                        startDateInput.addEventListener('clearDate', handleClearDate);
                        endDateInput.addEventListener('clearDate', handleClearDate);*/
    }
});
