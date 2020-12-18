// Sweet Alert configs - MODAL E TOAST
window.swalModal = Swal.mixin({
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  confirmButtonText: 'Tenho',
  cancelButtonText: 'Cancelar',
  buttonsStyling: false,
  customClass: {
    confirmButton: 'btn btn-lg btn-primary mr-2',
    cancelButton: 'btn btn-lg btn-light'
  }
});

window.swalToastInit = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 4500,
  timerProgressBar: false,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
});

window.toast = {
  success(message) {
    return swalToastInit.fire({
      icon: 'success',
      title: message,
      iconColor: '#38c172'
    });
  },

  warning(message) {
    return swalToastInit.fire({
      icon: 'warning',
      iconHtml: '<i class="fas fa-exclamation-triangle"></i>',
      title: message,
      iconColor: '#f69220'
    });
  },

  error(message) {
    return swalToastInit.fire({
      icon: 'error',
      iconHtml: '<i class="fas fa-times"></i>',
      title: message,
      iconColor: '#e3342f'
    });
  }
}
