@extends('layouts.app')

@section('title', $client->name . ' - ')

@section('content')
  <div class="container mt-5">

    <div>
      
    </div>

    <div class="row">
      <div class="col-md-3">
        <div class="mb-2">
          <a href="{{ route('clients.index') }}" class="btn btn-outline-primary">
            <i class="fas fa-arrow-alt-circle-left fa-fw mr-1"></i>Voltar
          </a>
        </div>

        @include('clients._client-card')
      </div>

      <div class="col-md-9">
        <div class="mb-2">
          <a href="{{ route('orders.create', $client) }}" class="btn btn-primary font-weight-bold">
            <i class="fas fa-plus fa-fw mr-1"></i>NOVO PEDIDO
          </a>  
        </div>

        <div class="card">
          <div class="card-header bg-primary text-white">
            <h6 class="font-weight-bold mb-0">
              <i class="fas fa-boxes"></i> Pedidos
            </h6>
          </div>

          <div class="card-body px-0">
            <table class="table">
              <thead>
                <tr>
                  <th>Nome</th>
                  <th>Valor</th>
                  <th>Data</th>
                </tr>
              </thead>
              <tbody>
                @foreach($client->orders as $order)
                  <tr>
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
                    <td>{{ Helper::date($order->date, '%d/%m/%Y') }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>          
      </div>
    </div>
  </div>
@endsection