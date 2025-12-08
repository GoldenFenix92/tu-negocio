import './bootstrap';

// Importar Bootstrap JavaScript y Popper
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

// Importar Alpine.js
import Alpine from 'alpinejs';
window.Alpine = Alpine;

Alpine.start();

// Inicializar tooltips de Bootstrap
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

// Inicializar popovers de Bootstrap
const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl));
