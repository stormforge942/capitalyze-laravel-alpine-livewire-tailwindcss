import "./bootstrap";

import Alpine from "alpinejs";
import focus from "@alpinejs/focus";
import FormsAlpinePlugin from "../../vendor/filament/forms/dist/module.esm";
import NotificationsAlpinePlugin from "../../vendor/filament/notifications/dist/module.esm";
import "./../../vendor/power-components/livewire-powergrid/dist/powergrid";
import "./../../vendor/power-components/livewire-powergrid/dist/powergrid.css";
import "./datepicker.js";
import Swal from "sweetalert2";
window.Swal = Swal;

window.Alpine = Alpine;

Alpine.plugin(focus);
Alpine.plugin(FormsAlpinePlugin);
Alpine.plugin(NotificationsAlpinePlugin);

Alpine.start();

import "./range-slider-custom";
import "./css-tables";
import "./report-text-highlighter";

[...document.querySelectorAll(".moving-label-input")].forEach((input) => {
    input.addEventListener("blur", (e) => {
        let el = e.target.nextElementSibling;

        if (e.target.value) {
            el.classList.remove("top-[50%]");
            el.classList.add("top-4");
            el.classList.add("text-sm");
        } else {
            el.classList.add("top-[50%]");
            el.classList.remove("top-4");
            el.classList.remove("text-sm");
        }
    });
});
