import VueProgressBar from "vue-progressbar";

window.Vue = require('vue');

Vue.use(VueProgressBar, {
    color: '#343a40',
    failedColor: '#874b4b',
    thickness: '4px',
    transition: {
        speed: '800s',
        opacity: '1s',
        termination: 800
    },
    location: 'top',
});


try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}



window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';



let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

