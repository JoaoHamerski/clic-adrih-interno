@extends('layouts.app')

@section('title', $client->name . ' - ')

@section('content')

<div class="mt-5">
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
      <div class="mb-2 mt-5 mt-md-0">
        <a href="{{ route('orders.create', $client) }}" 
          class="btn btn-primary font-weight-bold">
          <i class="fas fa-plus fa-fw mr-1"></i>NOVO PEDIDO
        </a>
      </div>
      
      @include('clients._orders-card')
      
    </div>
  </div>
</div>
</div>
@endsection