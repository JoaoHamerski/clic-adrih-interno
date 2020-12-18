<modal id="modalPayment" color="primary">
  <template #header>
    <i class="fas fa-dollar-sign fa-fw"></i>
    Efetuar pagamento
  </template>

  <template #body>
  <div class="modal-body px-0">
    <order-installments inline-template>
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
            <td>
              @{{ $helpers.formatMoney(installment.value) }}
            </td>

            <td class="text-center">
              @{{ this.moment(installment.due_date).format('DD/MM/YYYY') }}
            </td>

            <td class="text-center">
              <div v-if="installment.paid_at">
                <span class="d-inline-block disabled-tooltip" data-toggle="tooltip" title="Parcela já foi paga">
                  <button disabled="disabled" class="btn btn-success">Pagar</button>
                </span>
              </div>

              <div v-else>
                  <button class="btn btn-success" 
                  @click.prevent="payInstallment(index, installment.id)">
                    Pagar
                  </button>
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