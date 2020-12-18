class Errors {
	constructor() {
		this.errors = { };
	}

	get(field) {
		if (this.errors[field]) {
			return this.errors[field][0];
		}
	}

	has(field) {
		return this.errors.hasOwnProperty(field);
	}

	any() {
		return this.count() > 0;
	}

	count() {
		return Object.keys(this.errors).length;
	}

	clear(field = null) {
		if (field) {
			delete this.errors[field];

			return;	
		}

		if (field == '*') {
			this.errors = {};
		}
	}

	record(errors) {
		this.errors = errors;
	}
}

export default Errors;