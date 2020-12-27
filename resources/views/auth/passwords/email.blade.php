@extends('layouts.app')

@section('title', 'Esqueci minha senha - ')

@section('content')
  <div class="container">
    <div class="col-md-4 mx-auto mt-5">
      <div class="card">
        <div class="card-header bg-primary text-white font-weight-bold">
          ESQUECI MINHA SENHA
        </div>

        <div class="card-body">
          <div class="text-center text-dark">
            <i class="fas fa-lock fa-4x"></i>
          </div>


          <send-reset-password-form inline-template>
            <div v-if="emailSent">
              <div class="text-center mt-4 text-secondary small">
                Um e-mail com as instruções de redefinição <strong>foi enviado para o endereço abaixo</strong>, por favor, verifique sua <strong>caixa de entrada</strong> e <strong>lixo eletrônico</strong>.
              </div>

              <hr class="mb-4">

              <h6 class="text-center text-dark font-weight-bold">@{{ form.email }}</h6>

              <div class="text-center small mt-4">
                <a href="{{ route('auth.showLoginForm') }}">Voltar para a tela de login</a>
              </div>
            </div>
            <div v-else>
              <div class="text-center mt-4 text-secondary small">
                Digite seu e-mail para enviar as instruções de redefinição de senha
              </div>

              <hr class="mb-4">
              <form @submit.prevent="onSubmit"
                @keypress.enter.prevent="onSubmit"
                @focus.capture="clear($event.target.name)">

                <md-input name="email" 
                  label="E-mail"
                  v-model="form.email"
                  :autofocus="true"
                  :error-message="form.errors.get('email')"></md-input>

                <button :disabled="form.isLoading" type="submit" 
                  class="btn btn-block btn-primary font-weight-bold"> 
                  <span v-if="form.isLoading" 
                    class="spinner-border spinner-border-sm" 
                    role="status" 
                    aria-hidden="true"></span>
                  ENVIAR E-MAIL
                </button>

                <div class="mt-2">
                  <a class="small" href="{{ route('auth.showLoginForm') }}">Voltar à tela de login</a>
                </div>
              </form>
            </div>
          </send-reset-password-form>
        </div>
      </div>
    </div>
  </div>  
@endsection
