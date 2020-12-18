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

		return Number(str.trim());
	},
	formatMoney(str) {
		if (typeof str === 'string') {
			str = parseFloat(str);
		}

		return new Intl.NumberFormat('pt-BR', {
			style: 'currency',
			currency: 'BRL'
		}).format((str).toFixed(2));
	},
	mergeRecursive(obj1, obj2) {

	  for (var p in obj2) {
	    try {
	      // Property in destination object set; update its value.
	      if ( obj2[p].constructor==Object ) {
	        obj1[p] = this.mergeRecursive(obj1[p], obj2[p]);

	      } else {
	        obj1[p] = obj2[p];

	      }

	    } catch(e) {
	      // Property in destination object not set; create it and set its value.
	      obj1[p] = obj2[p];

	    }
	  }

	  return obj1;
	}
}