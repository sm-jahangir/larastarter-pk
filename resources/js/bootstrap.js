window._ = require('lodash');


try {
    window.$ = window.jQuery = require('jquery');
    window.Swal = require('sweetalert2');
    require('nestable2/jquery.nestable');
} catch (e) {}


window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
