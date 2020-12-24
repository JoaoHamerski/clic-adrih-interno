require('./bootstrap');
require('./core/vue-directives');
require('./core/vue-plugins');
require('./core/vue-mixins');
require('./_swal');
require('./components');
require('./init');

window.addEventListener('beforeinstallprompt', (event) => {
  window.deferredPrompt = event;
});

$('#btnInstallPWA').on('click', function(event) {
	console.log('ao');
	const promptEvent = window.deferredPrompt;

	if (! promptEvent) {
		return;
	}

	promptEvent.prompt();

	promptEvent.userChoice.then((result) => {
		window.deferredPrompt = null;
	});
});