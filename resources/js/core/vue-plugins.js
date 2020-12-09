import helpers from './../util/vue-helpers';
import masks from './../util/vue-masks';

const plugin = {
	install (Vue, options) {
		Vue.prototype.$helpers = helpers;
		Vue.prototype.$masks = masks;
	}
}

Vue.use(plugin);