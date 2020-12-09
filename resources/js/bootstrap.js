import Vue from 'vue';
import axios from 'axios';
import jQuery from 'jquery';
import Popper from 'popper.js';
import Swal from 'sweetalert2'
import toastr from 'toastr';
import bootstrap from 'bootstrap';
import Cookies from 'js-cookie'
import moment from 'moment';

window.Vue = Vue;
window.$ = window.jQuery = jQuery;
window.Popper = Popper.default;
window.toastr = toastr;
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.Cookies = Cookies;
window.moment = moment;


