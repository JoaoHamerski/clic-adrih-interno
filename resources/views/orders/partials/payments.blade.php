<div class="mt-4">
  <h5 class="font-weight-bold  text-secondary">Pagamentos</h5>

  <ul class="list-group list-group-flush">
    @foreach($order->payments->reverse() as $payment)
      <li class="list-group-item ">
        <div>
        <strong>{{ Mask::money($payment->value) }}</strong>
         em 
         <strong>{{ Helper::date($payment->date, '%d/%m/%Y') }}</strong>
         </div>

         @if ($payment->note)
          <small class="text-secondary">
           {{ $payment->note }}
          </small>
         @endif
      </li>
    @endforeach
  </ul>
</div>