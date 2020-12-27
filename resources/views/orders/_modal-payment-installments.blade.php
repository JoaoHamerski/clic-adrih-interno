<modal id="modalPayment" color="primary" modal-dialog-class="modal-dialog-md">
  <template #header>
    <i class="fas fa-dollar-sign fa-fw"></i>
    Efetuar pagamento
  </template>

  <template #body>
  <div class="modal-body px-0">
    <order-installments-form inline-template>
    <div class="position-relative">
      <div v-if="isLoading" class="loading">
        <div class="spinner-grow text-primary" role="status"></div>
      </div>

      <table class="table">
        <thead>
          <tr>
            <th>Valor</th>
            <th class="text-center">Data de vencimento</th>
            <th class="text-center">Ação</th>
          </tr>
        </thead>

        <tbody>
          <template v-for="(installment, index) in installments">
          <tr :class="{ 'table-success' : installment.paid_at }">
            <td class="align-middle">
              @{{ $helpers.formatMoney(installment.value) }}
              <span class="small text-muted no-wrap d-block" 
                v-if="! installment.paid_at && installment.total_paid > 0">
                (@{{ $helpers.formatMoney(installment.total_paid) }} já pago)
              </span>
            </td>

            <td class="text-center align-middle">
              @{{ this.moment(installment.due_date).format('DD/MM/YYYY') }}
            </td>

            <td>
              <div class="d-flex flex-column flex-md-row justify-content-between" 
              v-if="installment.paid_at">
                <button disabled="disabled" 
                  class="btn btn-success mr-2 mx-auto mb-2 mb-md-0 no-wrap">
                  Pagar total
                </button>

                <button disabled="disabled" class="btn btn-outline-primary no-wrap">
                  Pagar parcial
                </button>
              </div>

              <div class="d-flex flex-column flex-md-row justify-content-between" v-else>
                <button class="btn btn-success mr-2 no-wrap mx-auto mb-2 mb-md-0" 
                  @click.prevent="payInstallment(index, installment.id)">
                  Pagar total
                </button>

                <button v-if="! installment.enableForm" class="btn btn-outline-primary no-wrap"
                  @click.prevent="installment.enableForm = true">
                  Pagar parcial
                </button>

                <button v-else class="btn btn-outline-secondary"
                  @click.prevent="installment.enableForm = false">Cancelar
                </button>
              </div>
            </td>
          </tr>

          <tr v-if="installment.enableForm">
            <td style="border-top: none" colspan="3">
              <div @focus.capture="installment.error = ''" class="d-flex justify-content-between">
                <md-input class="mb-0 col px-0"
                  @keypress.enter.native="payParcialInstallment(index, installment.id)"
                  name="value"
                  autocomplete="off"
                  label="Valor parcial" 
                  v-model="installment.parcialValue"
                  :input-group="true"
                  :mask="$masks.valueBRL"
                  :error-message="installment.error">
                    <template #input-append>
                      <div class="input-group-append">
                        <button :disabled="installment.isLoading" class="btn btn-outline-primary"
                          @click.prevent="payParcialInstallment(index, installment.id)">
                          <span v-if="installment.isLoading" class="spinner-border spinner-border-sm"></span>
                          Pagar
                        </button>
                      </div>
                    </template>
                  </md-input>
                
              </div>
            </td>
          </tr>
          </template>
        </tbody>
      </table>
    </div>
    </order-installments>
  </div>
  </template>

  <template #footer>
    <div class="modal-footer">
      <button class="btn btn-light" data-dismiss="modal">Fechar</button>
    </div>
  </template>
</modal>