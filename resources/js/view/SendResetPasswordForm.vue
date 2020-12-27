<script>
	import Form from '../util/Form';

	export default {
		mixins: [formMixin],
		data() {
			return {
				emailSent: false,
				form: new Form({
					email: ''
				})
			}
		},
		methods: {
			onSubmit() {
				this.form.isLoading = true;

				this.form.submit('post', this.$helpers.getLocationURL())
					.then(response => {
						toast.success('E-mail de redefinição enviado!');
						this.form.isLoading = false;
						this.emailSent = true;
					})
					.catch(error => {
						console.log(error);
					})
					.then(() => {
						this.form.isLoading = false;
					});	
			}
		}
	}
</script>