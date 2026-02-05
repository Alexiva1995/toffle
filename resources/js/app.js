/**
 * Main JS entry for Vite.
 * jQuery and Bootstrap must be global for the theme.
 */
import $ from 'jquery';
window.$ = window.jQuery = $;

import 'bootstrap';

import './core/app-menu.js';
import './core/app.js';
import '../assets/js/scripts.js';

import './scripts/customizer.js';
import './scripts/forms/form-select2.js';
