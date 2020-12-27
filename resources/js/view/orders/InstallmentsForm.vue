<script>
  export default {
    data() {
      return {
        isLoading: false,
        parcialValue: '',
        installments: []
      }
    },
    methods: {
      payInstallment(index, installmentId) {
        let installment = this.installments[index];

        let text = 'Pagando parcela de ' 
            + '<strong>' + this.$helpers.formatMoney(installment.value) + '</strong>' 
            + ' com vencimento para ' 
            + '<strong>' + moment(installment.due_date).format('DD/MM/YYYY') + '</strong>';

        let textRemaining = 'Pagando o restante '
            + '<strong> :total_remaining </strong>'
            +' da parcela de '
            + '<strong>' + this.$helpers.formatMoney(installment.value) + '</strong>' 
            + ' com vencimento para ' 
            + '<strong>' + moment(installment.due_date).format('DD/MM/YYYY') + '</strong>';


        swalModal.fire({
          icon: 'info',
          iconHtml: '<i class="fas fa-info-circle"></i>',
          iconColor: '#39a0da',
          title: 'Você tem certeza?',
          html: this.installments[index].total_paid == 0 
            ? text 
            : textRemaining,
          didOpen: (swal) => {
            swal.querySelector('#swal2-content').innerHTML = swal.querySelector('#swal2-content').innerHTML.replace(':total_remaining', this.$helpers.formatMoney(this.installments[index].total_remaining));
          }
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
      },
      payParcialInstallment(index, installmentId) {
        this.installments[index].isLoading = true;

        axios.post(this.$helpers.getLocationURL() + '/parcela/' + installmentId + '/pagar-parcial', {
          value: this.installments[index].parcialValue
        })
          .then(response => {
            this.installments[index].total_paid = response.data.total_paid;
            this.installments[index].total_remaining = response.data.total_remaining;
            this.installments[index].paid_at = response.data.paid_at;
            this.installments[index].enableForm = false;
            this.installments[index].parcialValue = '';

            toast.success('Pagamento parcial realizado com sucesso!');
            EventBus.$emit('update-dynamic-view', ['clientDetails', 'orderDetails']);
          })
          .catch(error => {
            toast.error('Verifique o campo do formulário.');
            this.installments[index].error = error.response.data.errors.value[0];
          })
          .then(() => { this.installments[index].isLoading = false });
      }
    },
    mounted() {
      let vm = this;

      axios.get(this.$helpers.getLocationURL() + '/get-order')
        .then(response => {
          this.installments = response.data.installments.map(el => {
            return vm.$helpers.mergeRecursive(el, {
              isLoading: false,
              enableForm: false, 
              parcialValue: '',
              error: ''
            });
          });
        });
    }
  }
</script>