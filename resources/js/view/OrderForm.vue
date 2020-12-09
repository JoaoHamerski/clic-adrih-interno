<script>
	import Form from './../util/Form';

	export default {
		mixins: [formMixin],
		data() {
			return {
				number_of_installments: '',
				due_initial_date: '',
				installment_value: '',
				installment_value_raw: '',
				total_value: '',
				form: new Form({
					payment_type: 'in_cash',
					name: '',
					price: '',
					date: '',
					installments: []
				})
			}
		},
		methods: {
			onSubmit() {
				if (this.isEdit)
					this.update();
				else
					this.store();
			},
			store() {
				this.form.isLoading = true;

				this.form.submit('post', this.$helpers.getLocationURL())
					.then(response => {
						window.location.href = response.redirect;
					})
					.then(() => {
						this.form.isLoading = false;
					});
			},
			update() {

			},
			updateInstallmentsDate() {
				if (this.due_initial_date.length >= 5) {
					let currentDate = moment(this.due_initial_date, 'DD/MM/YYYY');

					this.form.installments.forEach((el, index) => {
							el.due_date = currentDate.format('DD/MM/YYYY');
							currentDate.add(1, 'months');
					});
				}

				if (this.due_initial_date.length == 0) {
					this.form.installments.forEach(el => {
						el.due_date = '';
					});
				}
			},
			toggleDisableInput(property, input) {
				if (! this.$helpers.isEmpty(this[property])) {
					this.$refs[input].isDisabled = true;
				} else {
					this.$refs[input].isDisabled = false;
				}
			},
			updateInstallmentValue() {
				if (! this.$refs.total_value.isDisabled) {
					if (! this.$helpers.isEmpty(this.total_value_sanitized) &&
						! this.$helpers.isEmpty(this.number_of_installments)) {
						this.installment_value_raw = this.total_value_sanitized / this.number_of_installments;
						this.installment_value = this.$helpers.formatMoney(
							this.total_value_sanitized / this.number_of_installments
						);
					}
				}
			},
			updateTotalValue() {
				if (! this.$refs.installment_value.isDisabled) {
					if (! this.$helpers.isEmpty(this.installment_value_sanitized) &&
						! this.$helpers.isEmpty(this.number_of_installments)) {
						this.total_value = this.$helpers.formatMoney(
							this.installment_value_sanitized * this.number_of_installments
						);
					}
				}
			},
			updateInstallmentsValue() {
				if (! this.$helpers.isEmpty(this.installment_value_sanitized)) {
					this.form.installments.forEach(el => {
						el.value = this.installment_value;
						el.raw_value = this.installment_value_raw;
					});
				}
			},
			updateTotalValueFromInstallments() {
				let sum = 0;

				this.form.installments.forEach(el => {
					sum += parseFloat(this.$helpers.sanitizeMoney(el.value || '0.00'));
				});

				this.total_value = this.$helpers.formatMoney(sum);
			}
		},
		computed: {
			total_value_sanitized: function() {
				return this.$helpers.sanitizeMoney(this.total_value);
			},
			installment_value_sanitized: function() {
				return this.$helpers.sanitizeMoney(this.installment_value);
			}
		},
		watch: {
			total_value: function() {
				if (this.$helpers.isEmpty(this.total_value_sanitized)) 
					this.installment_value = '';

				if (this.isFocusedInput('total_value') || this.isFocusedInput('installment_value')) {
					this.updateInstallmentsValue();
				}
			},
			number_of_installments: function(value) {
				this.form.installments = [];

				for (let i = 0; i < value; i++) {
					this.form.installments.push({value: '', raw_value: '', due_date: ''});
				}

				this.updateInstallmentsValue();
				this.updateInstallmentsDate();
			},
			due_initial_date: function() {
				this.updateInstallmentsDate();
			},
			installment_value: function() {
				if (this.$helpers.isEmpty(this.installment_value_sanitized)) 
					this.total_value = '';
			}
		}
	}
</script>