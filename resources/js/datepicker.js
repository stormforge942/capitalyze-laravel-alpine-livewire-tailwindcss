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
