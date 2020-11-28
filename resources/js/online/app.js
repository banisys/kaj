import swal from 'sweetalert2';

require('./bootstrap');

window.swal =swal;

Vue.component('pagination', require('laravel-vue-pagination'));

