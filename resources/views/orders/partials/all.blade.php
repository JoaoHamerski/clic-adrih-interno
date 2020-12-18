
@include('orders.partials.details')

@if (! $order->installments->isEmpty())
	@include('orders.partials.installments')
@endif

@if (! $order->payments->isEmpty())
	@include('orders.partials.payments')
@endif