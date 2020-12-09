@extends('layouts.app')

@section('title', 'Crie sua conta - ')

@section('content')
  <div class="container mt-5">

    <div class="card">
      <div class="card-header bg-primary text-white pb-1">
        <h6 class="font-weight-bold">
          <i class="fas fa-user-plus fa-fw mr-1"></i>Crie sua conta
        </h6>
      </div>

      <div class="card-body">
        <div class="mb-4">
          <h6 class="font-weight-bold">Tipo de cadastro</h6>

          <div class="custom-radio custom-control custom-control-inline">
              <input type="radio"
              id="cpf"
              name="personType"
              checked="checked"
              data-target="#tab-cpf" 
              class="custom-control-input">

              <label class="custom-control-label" for="cpf">
                Pessoa física
              </label>
          </div>

          <div class="custom-radio custom-control custom-control-inline">
              <input type="radio"
              id="cnpj"
              name="personType"
              data-target="#tab-cnpj"
              class="custom-control-input">

              <label class="custom-control-label" for="cnpj">
                Pessoa jurídica
              </label>
          </div>
        </div>

        <div class="tab-content">
          <div class="tab-pane fade show active" id="tab-cpf">
            @include('auth.register-cpf-form')
          </div>

          <div class="tab-pane fade" id="tab-cnpj">
            @include('auth.register-cnpj-form')
          </div>
        </div>
        
      </div>
    </div>  
  </div>
@endsection

@push('script')
  <script type="text/javascript">
    $('input[name="personType"]').click(function() {
      $(this).tab('show');
      $(this).removeClass('active');
    });
  </script>
@endpush