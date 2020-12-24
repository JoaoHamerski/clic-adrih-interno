// Inicialização do EventBus do Vue
window.EventBus = new Vue();

// Instância root do Vue
new Vue({
  el: '#app'
});

// Linguagem do moment.js
moment.locale('pt-BR');

// Inicialização dos tooltips do Bootstrap
$('#app').tooltip({
  selector: '[data-toggle="tooltip"]'
});

// Service Worker
window.addEventListener('load', () => {
	if ('serviceWorker' in navigator) {
		navigator.serviceWorker.register('_service-worker.js');
	}
});