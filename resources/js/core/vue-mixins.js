window.formMixin = {
	props: {
		isEdit: { type: Boolean } 
	},
	methods: {
		resetPasswordFields() {
	        this.form.password = '';
	        this.form.password_confirmation = '';
	    },
	    clear(field) {
        	this.form.errors.clear(field);
	        this.$forceUpdate();
	    },
	    touchAllInputs() {
	        this.$nextTick(function() {
	            this.$children.forEach(el => {
	                el.$refs
	                	.maskedInput
	                	.$el
	                	.dispatchEvent(new Event('input', { bubbles: true }));
	            });
	        });
	    },
	    isFocusedInput(refProperty) {
	    	return this.$refs[refProperty].$refs.maskedInput.$el == document.activeElement;
	    }
	}
}
