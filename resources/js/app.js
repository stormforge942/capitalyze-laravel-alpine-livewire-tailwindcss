import './bootstrap';

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import FormsAlpinePlugin from '../../vendor/filament/forms/dist/module.esm'
import NotificationsAlpinePlugin from '../../vendor/filament/notifications/dist/module.esm'
import "./../../vendor/power-components/livewire-powergrid/dist/powergrid";
import "./../../vendor/power-components/livewire-powergrid/dist/powergrid.css";
import './datepicker.js';
import Swal from 'sweetalert2';
window.Swal = Swal;

window.Alpine = Alpine;

Alpine.plugin(focus)
Alpine.plugin(FormsAlpinePlugin)
Alpine.plugin(NotificationsAlpinePlugin)

Alpine.start();

import "./range-slider-custom";
import './css-tables';
