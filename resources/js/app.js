/**
 * Main JS entry for Vite.
 * jQuery and DataTables must be global for the theme and Blade inline scripts.
 */
import $ from 'jquery';
window.$ = window.jQuery = $;

// DataTables: cargar sobre el mismo jQuery que exponemos (orden importante)
// Los paquetes se adjuntan a window.jQuery al importar
import 'datatables.net';
import 'datatables.net-bs5';
import 'datatables.net-responsive';
import 'datatables.net-buttons';
import 'datatables.net-buttons-bs5';

// CSS de DataTables (Bootstrap 5; responsive/buttons se pueden añadir en Blade si hace falta)
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css';

import axios from 'axios';
window.axios = axios;
const csrfToken = document.head.querySelector('meta[name="csrf-token"]');
if (csrfToken) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.content;
}
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import 'bootstrap';

import './core/app-menu.js';
import './core/app.js';
import '../assets/js/scripts.js';

import './scripts/customizer.js';
import './scripts/forms/form-select2.js';
