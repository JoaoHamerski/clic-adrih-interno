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
				this.isLoading = true;

				axios.post(this.$helpers.getLocationURL() + '/parcela/' + installmentId + '/pagar')
					.then(response => {	
						this.installments[index] = response.data;
						this.isLoading = false; 

						EventBus.$emit('update-dynamic-view', ['clientDetails', 'orderDetails']);
						
						toast.success('Pagamento realizado com sucesso!');
					})
					.catch(error => { toast.error('Erro ao realizar pagamento') });
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