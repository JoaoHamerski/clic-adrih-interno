<div class="mt-4">
  <h5 class="font-weight-bold text-secondary mb-4">Parcelas</h5>

  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th class="text-center">Status</th>
          <th>Valor</th>
          <th>Vencimento</th>
          <th class="text-center">Pago em</th>
        </tr>
      </thead>

      <tbody>
        @foreach ($order->installments as $installment)
        <tr class="{{ $installment->isExpired() ? 'table-danger' : '' }}">
          <td class="text-center">
            @if ($installment->paid_at)
              <i class="fas fa-check-circle text-success"></i>
            @elseif ($installment->isExpired())
              <i class="fas fa-exclamation-circle text-danger"></i>
            @else
              <i class="fas fa-circle text-info"></i>
            @endif
          </td>
          <td>
            {{ Mask::money($installment->value) }}
            @if (! $installment->paid_at && $installment->total_paid > 0)
              <small class="text-muted no-wrap">
                ({{ Mask::money($installment->total_paid) }} parcial. pago)
              </small>
            @endif
          </td>

          <td>{{ Helper::date($installment->due_date, '%d/%m/%Y') }}</td>

          @if ($installment->paid_at)
            <td class="text-center">
              {{ Helper::date($installment->paid_at, '%d/%m/%Y') }}
            </td>
          @else
            <td class="text-center">-</td>
          @endif
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>