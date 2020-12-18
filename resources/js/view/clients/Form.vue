<script>
  import Form from './../../util/Form';

  export default {
    mixins: [formMixin],
    data () {
      return {
        form: new Form({
          person_type: 'cpf',
          name: '',
          cpf: '',
          cnpj: '',
          phone: [{number: '', is_main: true}],
          city: '',
          address: ''
        })
      }
    },

    methods: {
      onSubmit() {
        this.form.isLoading = true;

        if (this.isEdit) {
          this.update();
        } else 
          this.store();
      },

      store() {
        this.form.submit('post', '/clientes')
          .then(response => { 
            window.location.href = response.redirect;
          })
          .catch(error => {
            toast.error('Verifique os campos do formulário.');
            this.form.isLoading = false;
          });
      },

      update() {
        this.form.submit('patch', window.location.href)
          .then(response => {
            if (response.refresh) {
              window.location.href = response.redirect;

              return;
            } 

            EventBus.$emit(
              'update-dynamic-view', 
              'clientDetails', 
              response.redirect + '/get-client-details-view'
            );
            
            this.$parent.close();
            toast.success('Dados atualizados com sucesso!');
          })
          .catch(error => {
            toast.error('Verifique os campos do formulário.');
          })
          .then(() => { this.form.isLoading = false });
      }
    },
    mounted() {
      let vm = this;

      if (this.isEdit) {
        axios.get(this.$helpers.getLocationURL() + '/get-client')
          .then(response => {
            if (! response.data.form.phone.length) {
              response.data.form.phone = [{number: '', is_main: true}];
            }

            vm.form = new Form(response.data.form);
            this.touchAllInputs();
          });
      }
    }
  }
</script>