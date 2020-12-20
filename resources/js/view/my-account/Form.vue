<script>
	import Form from './../../util/Form';

	export default {
		mixins: [formMixin],
		props: {
			isEdit: {}
		},
		data() {
			return {
				form: new Form({
					fullname: '',
					email: '',
					password: '',
					passsword_confirmation: ''
				})
			}
		},
		methods: {
			onSubmit() {
				this.form.isLoading = true;

				this.form.submit('post', this.$helpers.getLocationURL())
					.then(response => {
						window.location.href = response.redirect;
					})
					.catch(error => {
						this.form.isLoading = false;
						toast.error('Verifique os campos do formulário.');
					});
			}
		},
		mounted() {
			if (this.isEdit) {
				axios.get(this.$helpers.getLocationURL() + '/get-data')
					.then(response => {
						this.form = new Form(this.$helpers.mergeRecursive(this.form, response.data));
					})
					.catch(error => {
						console.log(error);
					});
			}
		}
	}
</script>