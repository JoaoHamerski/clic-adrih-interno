<script>
	import Form from './../../util/Form';

	export default {
		mixins: [formMixin],
		data() {
			return {
				numberOfInstallments: '',
				dueInitialDate: '',
				installmentValue: '',
				installmentValueRaw: '',
				totalValue: '',
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
				if (this.form.payment_type == 'in_installment') {
					let sum = 0;
					this.form.installments.forEach(el => {
						sum += Number(el.value);
					});

					this.form.price = sum;
				}

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
					.catch(error => {
						if (this.isInstallmentsEmpty()) {
							toast.warning('Informe as parcelas.');
						} else {
							toast.error('Verifique os campos do formulário.');
						}

						this.form.isLoading = false;
					});
			},
			update() {
				this.form.isLoading = true;

				this.form.submit('patch', this.$helpers.getLocationURL())
					.then(response => {
						window.location.href = response.redirect;
					})
					.catch(error => {
						this.form.isLoading = false;
						toast.error('Verifique os campos do formulário.');
					})
			},
			isInstallmentsEmpty() {
				return 	this.form.payment_type == 'in_installment' && 
						this.form.errors.count() == 1 && 
						this.form.errors.has('price')
			},
			newInstallment() {
				this.form.installments.push({value: '', due_date: ''});
			},
			deleteInstallment(index) {
				if (! this.form.installments[index].paid_at)
					this.form.installments.splice(index, 1);

				this.updateTotalValueFromInstallments();
			},
			updateInstallmentsDate() {
				if (this.dueInitialDate.length >= 5) {
					let currentDate = moment(this.dueInitialDate, 'DD/MM/YYYY');

					this.form.installments.forEach((el, index) => {
							el.due_date = currentDate.format('DD/MM/YYYY');
							currentDate.add(1, 'months');
					});
				}

				if (this.dueInitialDate.length == 0) {
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
				if (! this.$refs.totalValue.isDisabled) {
					if (! this.$helpers.isEmpty(this.total_value_sanitized) &&
						! this.$helpers.isEmpty(this.numberOfInstallments)) {
						this.installmentValueRaw = this.total_value_sanitized / this.numberOfInstallments;
						this.installmentValue = this.$helpers.formatMoney(
							this.total_value_sanitized / this.numberOfInstallments
						);
					}
				}
			},
			updateTotalValue() {
				if (! this.$refs.installmentValue.isDisabled) {
					if (! this.$helpers.isEmpty(this.installment_value_sanitized) &&
						! this.$helpers.isEmpty(this.numberOfInstallments)) {
						this.totalValue = this.$helpers.formatMoney(
							this.installment_value_sanitized * this.numberOfInstallments
						);
					}
				}
			},
			updateInstallmentsValue() {
				if (! this.$helpers.isEmpty(this.installment_value_sanitized)) {
					this.form.installments.forEach(el => {
						el.masked_value = this.installmentValue;
						el.value = this.installmentValueRaw;
					});
				}
			},
			updateTotalValueFromInstallments(value = null, index = null) {
				let sum = 0;
				
				if (value != null && index != null) {
					this.form.installments[index].value = this.$helpers.sanitizeMoney(value);
				}

				this.form.installments.forEach((el, subIndex) => {
					sum += Number(el.value || 0)
				});

				this.totalValue = this.$helpers.formatMoney(sum);
			}
		},
		computed: {
			total_value_sanitized: function() {
				return this.$helpers.sanitizeMoney(this.totalValue);
			},
			installment_value_sanitized: function() {
				return this.$helpers.sanitizeMoney(this.installmentValue);
			}
		},
		watch: {
			totalValue: function() {
				if (this.$helpers.isEmpty(this.total_value_sanitized)) 
					this.installmentValue = '';

				if (! this.isEdit)
					if (this.isFocusedInput('totalValue') || this.isFocusedInput('installmentValue')) {
						this.updateInstallmentsValue();
					}
			},
			numberOfInstallments: function(value) {
				this.form.installments = [];

				for (let i = 0; i < value; i++) {
					this.form.installments.push({masked_value: '', due_date: ''});
				}

				this.updateInstallmentsValue();
				this.updateInstallmentsDate();
			},
			dueInitialDate: function() {
				this.updateInstallmentsDate();
			},
			installmentValue: function() {
				if (this.$helpers.isEmpty(this.installment_value_sanitized)) 
					this.totalValue = '';
			}
		},
		mounted() {
			if (this.isEdit) {
				let vm = this;

				axios.get(this.$helpers.getLocationURL().replace('/alterar-dados', '') + '/get-order')
					.then(response => {
						response.data.date = moment(response.data.date).format('DD/MM/YYYY');
						response.data.masked_price = this.$helpers.formatMoney(response.data.price);

						if (response.data.installments.length == 0) {
							response.data.payment_type = 'in_cash';
						} else {
							response.data.payment_type = 'in_installment';
							response.data.installments = response.data.installments.map(el => {
								el.due_date = moment(el.due_date).format('DD/MM/YYYY');
								el.masked_value = vm.$helpers.formatMoney(el.value);

								return el;
							});

							this.totalValue = response.data.masked_price;
						}
						
						this.form = new Form(response.data);
					});
			}
		}
	}
</script>