<div class="mt-4">
  <h5 class="font-weight-bold text-secondary mb-4">Parcelas</h5>

  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>Valor</th>
          <th>Vencimento</th>
          <th>Pago em</th>
        </tr>
      </thead>

      <tbody>
        @foreach ($order->installments as $installment)
        <tr class="{{ $installment->isExpired() ? 'table-danger' : '' }}">
          <td>{{ Mask::money($installment->value) }}</td>
          <td>{{ Helper::date($installment->due_date, '%d/%m/%Y') }}</td>

          @if ($installment->paid_at)
            <td class="text-success">
              <i class="fas fa-check-circle fa-fw mr-1"></i>{{ Helper::date($installment->paid_at, '%d/%m/%Y') }}
            </td>
          @else
            <td>Não paga ainda</td>
          @endif
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>