@extends('layouts.app')

@section('title', $order->name . ' - ')

@section('content')
    <div class="mt-5">
      <div class="row">
        <div class="col-md-3">
          <div class="mb-2">
            <a href="{{ route('clients.show', $order->client) }}" class="btn btn-outline-primary">
              <i class="fas fa-arrow-alt-circle-left fa-fw mr-1"></i>Voltar
            </a>
          </div>

          @include('clients._client-card')
        </div>

        <div class="col-md-9">
          <div class="mb-2 d-flex flex-column flex-md-row justify-content-md-between justify-content-center">
            <div class="my-2 mt-4 my-md-0">
              @if ($order->isPaid())
              <span class="disabled-tooltip" 
                data-placement="bottom" 
                data-toggle="tooltip" 
                title="Não é possível efetuar pagamentos para pedidos já pagos">
                <button class="btn btn-block btn-success" disabled="disabled">
                  <i class="fas fa-dollar-sign fa-fw mr-1"></i> Efetuar pagamento
                </button>
              </span>

              @else
              
              <button class="btn btn-block btn-success" 
                data-toggle="modal" 
                data-target="#modalPayment">
                <i class="fas fa-dollar-sign fa-fw mr-1"></i> Efetuar pagamento
              </button>
              @endif
            </div>
            
            <div class="d-flex justify-content-between">
              <a href="{{ route('orders.edit', ['client' => $order->client, 'order' => $order]) }}" 
                class="btn btn-primary mr-1">
                <i class="fas fa-edit fa-fw mr-1"></i>Editar
              </a>

              <a id="btnDeleteOrder" href="" class="btn btn-outline-danger">
                <i class="fas fa-trash-alt fa-fw mr-1"></i>Deletar pedido
              </a>
            </div>
          </div>

          <div class="card">
            <div class="card-header bg-primary">
              <h6 class="font-weight-bold text-white mb-0">
                <i class="fas fa-box fa-fw mr-1"></i>Pedido 
              </h6>
            </div>

            <div class="card-body position-relative">
              <dynamic-view id="orderDetails" 
                url="{{ route('orders.show.details', [$order->client, $order]) }}"></dynamic-view>
            </div>
          </div>
        </div>          
      </div>  
    </div>

    @if ($order->hasInstallments())
      @include('orders._modal-payment-installments')
    @else
      @include('orders._modal-payment-cash')
    @endif
@endsection

@push('script')
  <script>
    $('#btnDeleteOrder').click(function(e) {
      e.preventDefault();

      swalModal.fire({
        title: 'Você tem certeza?',
        text: 'Isso excluirá o pedido e seus pagamentos do sistema.',
        icon: 'warning',
          iconHtml: '<i class="fas fa-exclamation-triangle"></i>',
          iconColor: '#f69220'
      }).then((result) => {
        if (result.isConfirmed) {
          axios.delete(Vue.prototype.$helpers.getLocationURL() + '/delete')
            .then(response => {
              window.location.href = response.data.redirect;
            });
        }
      });
    });
  </script>
@endpush