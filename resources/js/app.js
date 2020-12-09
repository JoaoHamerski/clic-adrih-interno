require('./bootstrap');
require('./core/vue-directives');
require('./core/vue-plugins');
require('./core/vue-mixins');
require('./components');

new Vue({
  el: '#app',
  methods: {
    test() {
      console.log('ola');
    }
  }
});

$('#app').tooltip({
  selector: '[data-toggle="tooltip"]'
});

toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": true,
  "onclick": null,
  "showDuration": "4000",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "300",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
};
