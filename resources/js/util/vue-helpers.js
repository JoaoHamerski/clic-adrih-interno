export default {
	isEmpty(str) {
		return str == '' || typeof str == 'undefined' || str == null;
	},
	openInNewTab(href) {
	  Object.assign(document.createElement('a'), {
	    target: '_blank',
	    href: href,
	  }).click();
	},
	getLocationURL() {
		return window.location.protocol + '//' + window.location.host + window.location.pathname;
	},
	sanitizeMoney(str) {
		str = str.replace('R$', '');
		str = str.replace(/\./g, '');
		str = str.replace(',', '.');

		return str.trim();
	},
	formatMoney(str) {
		if (typeof str === 'string') {
			str = parseFloat(str);
		}

		return (new Intl.NumberFormat('pt-BR', {
			style: 'currency',
			currency: 'BRL'
		}).format((str).toFixed(2))).toString();
	}
}