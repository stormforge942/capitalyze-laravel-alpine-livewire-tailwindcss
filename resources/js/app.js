import "./bootstrap";

import Alpine from "alpinejs";
import focus from "@alpinejs/focus";
import Swal from "sweetalert2";
import FormsAlpinePlugin from "../../vendor/filament/forms/dist/module.esm";
import NotificationsAlpinePlugin from "../../vendor/filament/notifications/dist/module.esm";
import "./../../vendor/power-components/livewire-powergrid/dist/powergrid";
import "./../../vendor/power-components/livewire-powergrid/dist/powergrid.css";
import "./datepicker.js";
import "./range-slider-custom";
import "./css-tables";
import "./report-text-highlighter";

window.Swal = Swal;
window.Alpine = Alpine;

Alpine.plugin(focus);
Alpine.plugin(FormsAlpinePlugin);
Alpine.plugin(NotificationsAlpinePlugin);

document.addEventListener("alpine:init", () => {
    Alpine.data("passwordReset", () => ({
        password: "",

        passedRules: {
            length: false,
            uppercase: false,
            lowercase: false,
            symbol: false,
        },

        init() {
            this.$watch("password", (val) => {
                this.passedRules = this.checkPassword(val);
            });
        },

        checkPassword(password) {
            let passedRules = {};

            passedRules.length = password.length >= 8;
            passedRules.uppercase = password.match(/[A-Z]/);
            passedRules.lowercase = password.match(/[a-z]/);
            passedRules.symbol = password.match(
                /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/
            );

            return passedRules;
        },
    }));
});

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

    input.addEventListener("change", (e) => {
        let el = e.target.parentElement;

        // remove error border
        if (el.classList.contains("border-danger")) {
            el.classList.remove("border-danger");
            el.classList.add("border-[#D1D3D5]");
        }

        // remove error message
        if (el.nextElementSibling?.classList?.contains("text-danger")) {
            el.nextElementSibling.remove();
        }
    });
});

Alpine.start();