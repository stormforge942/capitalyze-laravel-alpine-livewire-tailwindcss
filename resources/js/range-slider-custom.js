document.addEventListener('DOMContentLoaded', function() {
    let rangeMin = 1997;
    let rangeMax = 2022;
    //init select year range slider
    rangeSlider(document.querySelector('#range-slider'), {
        step: 1,
        min: rangeMin,
        max: rangeMax,
        value: [2017, 2022],
    });
});
