window._ = require('lodash');


try {
    window.$ = window.jQuery = require('jquery');
    window.Swal = require('sweetalert2');
} catch (e) {}


window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
