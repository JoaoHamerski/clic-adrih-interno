<script>
	import Form from '../util/Form';

	export default {
		mixins: [formMixin],
		data() {
			return {
				form: new Form({
					token: '',
					email: '',
					password: '',
					password_confirmation: ''
				})
			}
		},
		methods: {
			onSubmit() {
				this.form.isLoading = true;

				this.form.submit('post', '/redefinir-senha')
					.then(response => {
						window.location.href = response.redirect;
					})
					.catch(error => {})
					.then(() => this.form.isLoading = false);
			}
		},
		mounted() {
			this.form.email = (new URLSearchParams(window.location.search)).get('email');
			this.form.token = this.$refs.token.value;
		}
	}
</script>