<div class="card">
  <div class="card-header bg-primary text-white">
    <h6 class="font-weight-bold mb-0">
    <i class="fas fa-boxes"></i> Pedidos
    </h6>
  </div>

  <div class="card-body px-0 position-relative">
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Nome</th>
            <th>Valor</th>
            <th>Falta pagar</th>
            <th>Data</th>
          </tr>
        </thead>
        <tbody>
          @foreach($orders as $order)
            <tr class="clickable"
              data-id="{{ $order->id }}"
              onclick="window.location = Vue.prototype.$helpers.getLocationURL() + '/pedidos/' + this.getAttribute('data-id')">

              <td>{{ $order->name }}</td>

              <td>
                {{ Mask::money($order->price) }}
                @if ($order->hasInstallments() && $order->isInstallmentsValueSame())
                  <small class="text-secondary">
                  ({{ $order->installments->count() }} x {{ Mask::money($order->installments()->first()->value) }})
                  </small>
                @elseif($order->hasInstallments())
                  <small class="text-secondary">(a prazo)</small>
                @endif
              </td>

              <td>
                @if ($order->isPaid())
                  <div class="text-success">
                    <i class="fas fa-check-circle fa-fw mr-1"></i>Pago
                  </div>
                @else
                  <div class="text-danger">
                    {{ Mask::money($order->getTotalOwing()) }}
                  </div>
                @endif
              </td>

              <td>{{ Helper::date($order->date, '%d/%m/%Y') }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="mt-2">
  {{ $orders->links() }}
</div>