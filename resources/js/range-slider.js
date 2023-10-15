import rangeSlider from "range-slider-input"
import "range-slider-input/dist/style.css"

document.addEventListener('DOMContentLoaded', function() {
    let rangeMin = 1997;
    let rangeMax = 2022;

    const el = document.querySelector('#range-slider');

    if(!el) {
        return;
    }

    //init select year range slider
    rangeSlider(el, {
        step: 1,
        min: rangeMin,
        max: rangeMax,
        value: [2017, 2022],
    });
});
