<script>
	export default {
		data() {
			return {
				isLoading: false,
				installments: []
			}
		},
		methods: {
			payInstallment(index, installmentId) {
				let installment = this.installments[index],
					text = 'Pagando parcela de ' 
						+ '<strong>' + this.$helpers.formatMoney(installment.value) + '</strong>' 
						+ ' com vencimento para ' 
						+ '<strong>' + moment(installment.due_date).format('DD/MM/YYYY') + '</strong>';

				swalModal.fire({
					icon: 'info',
					iconHtml: '<i class="fas fa-info-circle"></i>',
					iconColor: '#39a0da',
					title: 'Você tem certeza?',
					html: text 
				}).then(result => {
					if (result.isConfirmed) {
						this.isLoading = true;

						axios.post(this.$helpers.getLocationURL() + '/parcela/' + installmentId + '/pagar')
							.then(response => {
								this.installments[index] = response.data;

								EventBus.$emit('update-dynamic-view', ['clientDetails', 'orderDetails']);
								
								toast.success('Pagamento realizado com sucesso!');

								this.isLoading = false;
							});
					}
				});
			}
		},
		mounted() {
			axios.get(this.$helpers.getLocationURL() + '/get-order')
				.then(response => {
					this.installments = response.data.installments;
				});
		}
	}
</script>