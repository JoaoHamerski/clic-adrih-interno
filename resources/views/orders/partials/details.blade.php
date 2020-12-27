<div>

  <div class="d-flex align-items-center mb-4">
    @if ($order->isPaid())
      <div class="mr-2 text-success" data-toggle="tooltip" title="Pedido pago">
        <i class="fas fa-check-circle fa-2x"></i>  
      </div>
    @endif

    <div>
      <h5 class="font-weight-bold {{ $order->isPaid() ? 'text-success' : '' }} mb-0">{{ $order->name }}</h5>
      <span class="text-secondary">Pedido em {{ Helper::date($order->date, '%d/%m/%Y') }}</span>
    </div>
  </div>

  <div class="d-flex justify-content-between">
    <div>
      @if ($order->hasInstallments())
      <h6 class="font-weight-bold mb-1">Valor total: </h6>
      @else
      <h6 class="font-weight-bold mb-1">Preço: </h6>
      @endif
      
      {{ Mask::money($order->price) }}
    </div>

    <div class="{{ $order->isPaid() ? 'text-success' : 'text-danger'}}">
      <h6 class="font-weight-bold mb-1">Faltar pagar: </h6>
      @if ($order->isPaid())
        Já pago
      @else
        {{ Mask::money($order->getTotalOwing()) }}
      @endif
    </div>

    <div class="{{ $order->getTotalPaid() > 0 ? 'text-success' : '' }}">
      <h6 class="font-weight-bold mb-1">Total pago: </h6>
      {{ Mask::money($order->getTotalPaid()) }}
    </div>
  </div>
</div>