import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
    Alpine.store('reservation', {
        open: false,
        sending: false,
        confirmed: false,
        errorMsg: '',
        formData: {},
    });
});

Alpine.start();
