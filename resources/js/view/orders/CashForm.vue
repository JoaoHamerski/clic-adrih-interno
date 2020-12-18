<script>
	import Form from './../../util/Form';

	export default {
		mixins: [formMixin],
		data() {
			return {
				form: new Form({
					value: '',
					note: '',
					date: ''
				})
			}
		},
		methods: {
			onSubmit() {

				this.form.isLoading = true;

				this.form.submit('post', this.$helpers.getLocationURL() + '/pagar')
					.then(response => {
						EventBus.$emit('update-dynamic-view', ['orderDetails', 'clientDetails']);
						this.form.reset();
						this.$parent.close();
						
						toast.success('Pagamento realizado com sucesso!');
					})
					.catch(error => {
						toast.error('Verifique os campos do formulário.');
					})
					.then(() => {
						this.form.isLoading = false;
					});
			}
		}
	}
</script>