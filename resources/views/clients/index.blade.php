@extends('layouts.app')

@section('title', 'Clientes - ')

@section('content')
  <modal id="modalNewClient" color="primary">
    <template v-slot:header>
      <i class="fas fa-user-plus fa-fw mr-1"></i>
      Cadastro de novo cliente
    </template>

    <template v-slot:body>
      <div class="modal-body">
        @include('clients.form')
      </div>
    </template> 
  </modal>

  <div class="mt-5 mb-2">
    <button 
      data-toggle="modal" 
      data-target="#modalNewClient" 
      class="btn btn-success font-weight-bold">

      <i class="fas fa-user-plus fa-fw mr-1"></i>
      NOVO CLIENTE
    </button>
  </div>

  <div class="card">
    <div class="card-header bg-primary text-white font-weight-bold">
      <i class="fas fa-users fa-fw mr-1"></i>Clientes
    </div>

    <div class="card-body px-0">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Telefone</th>
              <th>Devendo</th>
            </tr>
          </thead>

          <tbody>
            @foreach($clients as $client)
              <tr class="clickable"
                  data-url="{{ $client->path() }}" 
                  onclick="window.location = this.getAttribute('data-url')">
                <td nowrap="nowrap"> {{ $client->name }} </td>
                <td nowrap="nowrap"> {{ Mask::phone($client->getPhone()) ?? '[não informado]' }} </td>
                <td nowrap="nowrap" class="{{ $client->getTotalOwing() > 0 ? 'text-danger' : '' }}">{{ Mask::money($client->getTotalOwing()) }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="mt-2">
    {{ $clients->links() }}
  </div>
@endsection