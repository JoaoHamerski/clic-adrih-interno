<script>
  import Form from './../util/Form';

  export default {
    mixins: [formMixin],
    data () {
      return {
        form: new Form({
          email: '',
          password: '',
          remember: ''
        })
      }
    },
    methods: {
      onSubmit() {
        this.form.isLoading = true;

        this.form.submit('post', '/entrar')
          .then(response => {
            window.location.href = response.redirect;
          })
          .catch(error => {
            this.form.isLoading = false;
            toast.error("Por favor, verifique as credenciais informadas.");

            if (this.form.errors.any()) {
              this.form.password = '';
            }
          });
      }
    }
  }
</script>