@extends('layouts.app')

@section('Pedidos - ')

@section('content')
    <form class="w-100" method="GET" action="{{ route('orders.index') }}">
  <div class="mt-5 mb-2 d-flex justify-content-start justify-content-md-end">
      <div class="form-group mb-0 col col-md-3 px-0">
        <div class="input-group">
          <input class="form-control"
            type="text"
            name="nome"
            placeholder="Nome do cliente..."
            value="{{ request('nome') }}">

          <div class="input-group-append">
            <button class="btn btn-outline-primary">Buscar</button>
          </div>
        </div>
      </div>
  </div>
    </form>

  <div class="card">
    <div class="card-header bg-primary position-relative">
      <a class="stretched-link" href="{{ route('orders.index') }}"></a>
      <h6 class="text-white font-weight-bold mb-0">
        <i class="fas fa-boxes fa-fw mr-1"></i>Pedidos
      </h6>
    </div>

    <div class="card-body px-0">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Cliente</th>
              <th>Pedido</th>
              <th>Valor</th>
              <th nowrap="nowrap">Total pago</th>
              <th nowrap="nowrap">Feito em</th>
            </tr>
          </thead>

          <tbody>
            @foreach ($orders as $order)
              <tr class="clickable"
                data-url="{{ $order->path() }}"
                onclick="window.location.href = this.getAttribute('data-url')">
                <td>{{ $order->client->name }}</td>
                <td>{{ $order->name }}</td>
                <td>{{ Mask::money($order->price) }}</td>
                @if ($order->isPaid())
                  <td nowrap="nowrap" class="text-success">
                    <i class="fas fa-check-circle fa-fw mr-1"></i> Já pago
                  </td>
                @else
                  <td nowrap="nowrap">{{ Mask::money($order->getTotalPaid()) }}</td>
                @endif
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
@endsection