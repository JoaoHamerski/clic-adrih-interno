@extends('layouts.app')

@section('title', 'Entrar - ')

@section('content')
  <div class="container">
    <div class="col-md-4 mx-auto mt-5">
      <div class="card">
        <div class="card-header bg-primary text-white font-weight-bold">
          ENTRE COM SUA CONTA
        </div>

        <div class="card-body">
          <div class="text-center text-dark">
            <i class="fas fa-user-circle fa-4x"></i>
          </div>

          <div>
            <login-form inline-template>
              <form @submit.prevent="onSubmit"
                    @keypress.enter.prevent="onSubmit"
                    @focus.capture="clear($event.target.name)">

                <h5 class="font-weight-bold text-dark text-center mt-3">Boas vindas</h5>

                <hr class="py-3 mt-4">

                <md-input name="email" 
                  ref="email"
                  label="E-mail"
                  v-model="form.email"
                  :autofocus="true"
                  :error-message="form.errors.get('email')"></md-input>

                <md-input
                  name="password" 
                  label="Senha" 
                  type="password"
                  v-model="form.password"
                  :error-message="form.errors.get('password')"></md-input>

                <div class="custom-control custom-checkbox">
                  <input type="checkbox" v-model="form.remember" name="remember" class="custom-control-input" id="remember">
                  <label class="custom-control-label" for="remember">Manter-se conectado</label>
                </div>

                <button :disabled="form.isLoading" class="btn btn-primary btn-block mt-4 font-weight-bold">
                  <span v-if="form.isLoading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                  ENTRAR
                </button>
              </form>
            </login-form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection